from models import Ingredient,Order,Recipe,Container,Pump,Liquid
import pumpcontrol
import threading
from threading import Thread
from collections import defaultdict

from logging_config import Logger

logger_singleton = Logger()
logger = logger_singleton.get_logger(__name__)

#Berechnet die Laufzeit der Pumpe basierend auf der Menge.
def getTime(amount, pump: Pump):
    return amount / pump.flowrate



def executeOrders(order):
    recipe_id = order.recipe_id
    recipe = Recipe.Database().selectByID(recipe_id)
    if not recipe:
        logger.error(f"Rezept mit ID {recipe_id} nicht gefunden!")
        Order.Database().updateStatus(order.id,4)
        return
    
    logger.info(f"{recipe.name} wird zubereitet")

    if (check_steps(order,recipe) == False):
        return   
    
    if (check_ingredients_enough(order) == False):
        return

    ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)
    # Berechne den maximalen Schritt des Rezepts
    maxstep =  max([int(ingredient.step) for ingredient in ingredients])
    # Schritte des Rezepts durchlaufen
    for step in range(maxstep+1):
        step = int(step)  # Sicherstellen, dass step ein Integer ist
        logger.info(f"Starte Schritt {step + 1} für {recipe.name}.")
        ingredient_step =  Ingredient.Database().selectByStepandRecipe_id(step,recipe_id)
        if not ingredient_step:
            continue

        # Gruppieren und summieren der Zutaten
        grouped_ingredients = group_and_sum_ingredients(ingredient_step)

        for grouped in grouped_ingredients:
            liquid_id = grouped["liquid_id"]
            total_amount = grouped["total_amount"]

            Threadtimes = [] 
            containers = Container.Database().selectByLiquid_id(liquid_id)
            liquid = Liquid.Database().selectByID(liquid_id)       
            pumps = collect_pumps_from_containers(containers)

            logger.debug(f"Verteile {total_amount} ml Flüssigkeit '{liquid.name}' auf {len(pumps)} Pumpe(n).")
            sorted_containers = sorted(containers, key=lambda obj: obj.current_volume)
            Threads = distribute_ingredient_among_pumps(pumps, total_amount,sorted_containers,Threadtimes)
            if Threads:
                Threadtimes.extend(Threads)

        # Warte darauf, dass alle Threads abgeschlossen sind
        for thread in Threadtimes:
            thread.join()   
        logger.info(f"Step {step+1} von {maxstep+1} abgeschlossen")
    
    # Bestellung abschließen
    Order.Database().updateStatus(order.id,2)
    logger.info(f"{recipe.name} ist fertig")

#Sammelt alle Pumpen, die den angegebenen Containern zugeordnet sind.
def collect_pumps_from_containers(containers):
    pumps = []
    for container in containers:
        container_pumps = Pump.Database().selectByContainerID(container.id)
        if container_pumps:
            pumps.extend(container_pumps)
    return pumps


#Verarbeitet die Verteilung einer Zutat auf mehrere Pumpen.
def distribute_ingredient_among_pumps(pumps, amount,containers,threads):  

    if containers and pumps:
    # Wähle den ersten Container
        amount_per_pump = amount / len(pumps)
        container = containers[0]
    else:
        return threads
    
    
    # Finde alle Pumpen, die mit dem aktuellen Container verbunden sind
    container_pumps = [pump for pump in pumps if pump.container_id == container.id]

    # Überprüfen, ob der Container fast leer ist (≤10 Einheiten verbleibend)
    if container.current_volume <= 10:
        # Entferne die Pumpen des aktuellen Containers aus der Pumpenliste
        remaining_pumps = [pump for pump in pumps if pump not in container_pumps]
        
        # Entferne den aktuellen Container aus der Containernliste
        remaining_containers = [item for item in containers if item != container]
        
        # Verteile die gesamte Menge auf die restlichen Pumpen und Container
        distribute_ingredient_among_pumps(remaining_pumps, amount, remaining_containers,threads)
    

 # Berechne die benötigte Menge für alle Pumpen des Containers
    container_amount_needed = len(container_pumps) * amount_per_pump
    
    # Überprüfen, ob das Verteilen den Container fast leeren würde (≤10 Einheiten verbleibend)
    if container.current_volume - container_amount_needed <= 10:
        # Passe die Menge pro Pumpe an, sodass nur bis 10 Einheiten Restvolumen gefüllt wird
        amount_per_pump = (container.current_volume - 10) / len(container_pumps)
        
        # Gib die berechnete Menge an die Pumpen des Containers aus
        threads.extend(ausgabe(amount_per_pump, container_pumps))

        # Entferne die Pumpen des aktuellen Containers aus der Pumpenliste
        remaining_pumps = [pump for pump in pumps if pump not in container_pumps]
        
        # Entferne den aktuellen Container aus der Containernliste
        remaining_containers = [item for item in containers if item != container]
        
        # Verteile den Rest der Menge auf die restlichen Pumpen und Container
        remaining_amount = amount - (container.current_volume - 10)
        distribute_ingredient_among_pumps(remaining_pumps, remaining_amount, remaining_containers,threads)

    else:
        # Wenn genug Platz im Container ist, verteile die gesamte Menge pro Pumpe
        threads.extend(ausgabe(amount_per_pump, container_pumps))
        
        # Entferne die Pumpen des aktuellen Containers aus der Pumpenliste
        remaining_pumps = [pump for pump in pumps if pump not in container_pumps]
        
        # Entferne den aktuellen Container aus der Containernliste
        remaining_containers = [item for item in containers if item != container]
        
        # Verteile den verbleibenden Teil der Menge
        remaining_amount = amount - container_amount_needed
        distribute_ingredient_among_pumps(remaining_pumps, remaining_amount, remaining_containers,threads)


def ausgabe(amount_per_pump,pumps):
    threads = []
    # Die maximale Zeit, die für das Abpumpen benötigt wird
    
    for pump in pumps:
        pumptime = getTime(amount_per_pump,pump)

        # Thread für das Starten der Pumpe
        pump_thread = Thread(target=pumpcontrol.start_pumpfor, args=(pump.pin, pumptime))
        pump_thread.start()
        threads.append(pump_thread)

        # Thread für das Aktualisieren des Volumens
        volume_thread = Thread(
            target=update_volume,
            args=(pump.container_id, amount_per_pump)
        )
        volume_thread.start()
        threads.append(volume_thread)
    return threads     



def update_volume(container_id, volume):
    with threading.Lock():  # Sicherstellen, dass immer nur ein Thread den Codeblock ausführt
        # Kritische Datenbankoperationen oder Änderungen
        Container.Database().updateCurrent_volume(container_id, volume)

def group_and_sum_ingredients(ingredients):
    grouped_ingredients = defaultdict(float)  # Verwende float für Summierung von Mengen

    # Gruppiere und summiere
    for ingredient in ingredients:
        grouped_ingredients[ingredient.liquid_id] += ingredient.amount

    # Erstelle eine Liste mit den aggregierten Ergebnissen
    result = [
        {"liquid_id": liquid_id, "total_amount": total_amount}
        for liquid_id, total_amount in grouped_ingredients.items()
    ]

    return result

def check_ingredients_enough(order):
    # Lade alle Zutaten des Rezepts
    ingredients = Ingredient.Database().selectByRecipe_id(order.recipe_id)

    # Erstelle ein Dictionary, um den Gesamtbedarf für jede Flüssigkeit zu berechnen
    required_liquid_amounts = {}

    # Berechne die Gesamtmenge jeder Flüssigkeit, die für das Rezept benötigt wird
    for ingredient in ingredients:
        if ingredient.liquid_id not in required_liquid_amounts:
            required_liquid_amounts[ingredient.liquid_id] = 0
        required_liquid_amounts[ingredient.liquid_id] += ingredient.amount

    # Überprüfe, ob die vorhandene Menge ausreicht
    for liquid_id, required_amount in required_liquid_amounts.items():
        
        # Lade die Container mit der entsprechenden Flüssigkeit
        containers = Container.Database().selectByLiquid_id(liquid_id)
        valid_containers = []
        for container in containers:
            container_pumps = Pump.Database().selectByContainerID(container.id)
            if container_pumps:
                valid_containers.append(container)

        # Berechne das gesamte verfügbare Volumen für diese Flüssigkeit
        total_volume_container = sum(container.current_volume for container in valid_containers)

        # Mindestvolumen-Bedingung überprüfen
        if total_volume_container - required_amount <= 10 * len(containers):
            # Flüssigkeit reicht nicht aus
            liquid_name = Liquid.Database().selectByID(liquid_id).name  # Name der Flüssigkeit holen
            logger.info(f"Es ist zu wenig Flüssigkeit '{liquid_name}' vorhanden. Kann nicht zubereitet werden")
            Order.Database().updateStatus(order.id, 4)  # Bestellung als fehlgeschlagen markieren
            return False  # Prüfung fehlgeschlagen

    # Alle Flüssigkeiten reichen aus
    return True

def check_steps(order,recipe):
    ingredients = Ingredient.Database().selectByRecipe_id(recipe.id)
    if not ingredients:
        logger.error(f"Keine Zutaten für Rezept ID {recipe.id} gefunden.")
        Order.Database().updateStatus(order.id,4)
        return False
    maxstep =  max([int(ingredient.step) for ingredient in ingredients])
    # Überprüfen, ob alle Schritte im Rezept Zutaten haben
    for step in range(maxstep + 1):
        logger.debug(f"Überprüfe Schritt {step + 1} für {recipe.name}.")
        ingredient_step = Ingredient.Database().selectByStepandRecipe_id(step, recipe.id)
        
        # Überprüfen, ob Zutaten für diesen Schritt vorhanden sind
        if not ingredient_step:
            logger.warning(f"Keine Zutaten für Schritt {step + 1} gefunden. Überspringe.")
            continue
        
        # Gruppieren und summieren der Zutaten
        grouped_ingredients = group_and_sum_ingredients(ingredient_step)

        for grouped in grouped_ingredients:
            liquid_id = grouped["liquid_id"]

            liquid = Liquid.Database().selectByID(liquid_id)
            # Überprüfen, ob die Flüssigkeit existiert
            if not liquid:
                logger.error(f"Flüssigkeit mit ID {liquid_id} nicht gefunden. Abbruch!")
                Order.Database().updateStatus(order.id, 4)
                return False
            
            containers = Container.Database().selectByLiquid_id(liquid_id)
            # Überprüfen, ob Container für die Flüssigkeit vorhanden sind
            if not containers:
                logger.error(f"Keine Container für Flüssigkeit '{liquid.name}' gefunden. Abbruch!")
                Order.Database().updateStatus(order.id, 4)
                return False

            # Überprüfen, ob Pumpen für den Container existieren
            pumps = collect_pumps_from_containers(containers)

            if not pumps:
                logger.error(f"Keine Pumpen für Flüssigkeit '{liquid.name}' gefunden. Abbruch!")
                Order.Database().updateStatus(order.id, 4)
                return False
            
    return True



#überprüfen noch anpassen auf container die auch angeschlossen sind; 