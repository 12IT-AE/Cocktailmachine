from models import Default_Recipe
from models import Ingredient,Order,Container,Pump,Liquid
import pumpcontrol
import threading
from threading import Thread
from collections import defaultdict

from logging_config import Logger

logger_singleton = Logger()
logger = logger_singleton.get_logger(__name__)

def executeOrders(order):
    odefault_recipe_id = order.default_recipe_id
    default_recipe = Default_Recipe.Database().selectByID(odefault_recipe_id)
    if not default_recipe:
        logger.error(f"Rezept mit ID {odefault_recipe_id} nicht gefunden!")
        Order.Database().updateStatus(order.id,4)
        return
    
    logger.info(f"{default_recipe.name} wird zubereitet")

    if (check_steps(default_recipe.name,order.id) == False):
        return   
    
    if (check_ingredients_enough(order) == False):
        return

    ingredients = Ingredient.Database().selectByOrder_id(order.id)
    # Berechne den maximalen Schritt des Rezepts
    maxstep = max([int(ingredient.step) for ingredient in ingredients])
    # Schritte des Rezepts durchlaufen
    for step in range(maxstep+1):
        step = int(step)  # Sicherstellen, dass step ein Integer ist
        logger.info(f"Starte Schritt {step + 1} für {default_recipe.name}.")
        ingredient_step =  Ingredient.Database().selectByStepandOrder_id(step,order.id)
        if not ingredient_step:
            continue
        all_threads = []
        # Gruppieren und summieren der Zutaten
        grouped_ingredients = group_and_sum_ingredients(ingredient_step)
         
        for grouped in grouped_ingredients:
            liquid_id = grouped["liquid_id"]
            total_amount = grouped["total_amount"]

            
            containers = Container.Database().selectByLiquid_id(liquid_id)
            liquid = Liquid.Database().selectByID(liquid_id)       
            pumps = collect_pumps_from_containers(containers)

            logger.debug(f"Verteile {total_amount} ml Flüssigkeit '{liquid.name}' auf {len(pumps)} Pumpe(n).")
            sorted_containers = sorted(containers, key=lambda obj: obj.current_volume)
            threads = distribute_ingredient_among_pumps(pumps, total_amount,sorted_containers,[])
            all_threads.extend(threads)

        # Warte darauf, dass alle Threads abgeschlossen sind
        for thread in all_threads:
            thread.join()   
        logger.info(f"Step {step+1} von {maxstep+1} abgeschlossen")
    
    # Bestellung abschließen
    Order.Database().updateStatus(order.id,2)
    logger.info(f"{default_recipe.name} ist fertig")

#Sammelt alle Pumpen, die den angegebenen Containern zugeordnet sind.
def collect_pumps_from_containers(containers):
    return [pump for container in containers for pump in Pump.Database().selectByContainerID(container.id)]


#Verarbeitet die Verteilung einer Zutat auf mehrere Pumpen.
def distribute_ingredient_among_pumps(pumps, amount,containers,threads):  

    if not containers or not pumps:
        return threads
    
    # Wähle den ersten Container
    container = containers[0]

    # Finde alle Pumpen, die mit dem aktuellen Container verbunden sind
    container_pumps = [pump for pump in pumps if pump.container_id == container.id]

    # Berechne die Gesamtflussrate der Pumpen
    total_flowrate = sum(pump.flowrate for pump in container_pumps)

    # Prüfe, ob der Container leer oder negativ ist
    available_volume = max(container.current_volume-10, 0)
    if total_flowrate <= 0 or available_volume == 0 :
        # Wenn keine effektive Flussrate vorhanden ist, überspringe diesen Container
        remaining_pumps = [pump for pump in pumps if pump not in container_pumps]
        remaining_containers = [item for item in containers if item != container]
        return distribute_ingredient_among_pumps(remaining_pumps, amount, remaining_containers, threads)
    
    # Berechne die Zeit, die alle Pumpen benötigen, um gleichzeitig fertig zu werden
    time_to_distribute  = amount / total_flowrate

     # Berechne die zu verteilende Menge für jede Pumpe basierend auf ihrer Flussrate
    amount_per_pump = {Pump: pump.flowrate * time_to_distribute  for pump in container_pumps}

    # Berechne die Gesamtmenge, die der aktuelle Container bereitstellen kann
    total_amount_needed = sum(amount_per_pump.values())
    if total_amount_needed > available_volume:
        # Passe die Mengen an, um den Container nicht vollständig zu leeren
        adjustment_factor = available_volume / total_amount_needed
        amount_per_pump = {pump: amount * adjustment_factor for pump, amount in amount_per_pump.items()}
        remaining_amount = amount - available_volume
    else:
        remaining_amount = amount - total_amount_needed

    threads.extend(ausgabe((amount-remaining_amount), container_pumps,time_to_distribute))

    # Entferne die verbrauchten Pumpen und Container
    remaining_pumps = [pump for pump in pumps if pump not in container_pumps]
    remaining_containers = [item for item in containers if item != container]

    # Verteile den Rest auf die verbleibenden Container und Pumpen
    return distribute_ingredient_among_pumps(remaining_pumps, remaining_amount, remaining_containers, threads)



def ausgabe(removedVolume,pumps,pumptime):
    threads = []
    # Die maximale Zeit, die für das Abpumpen benötigt wird
    for pump in pumps:
        # Thread für das Starten der Pumpe
        pump_thread = Thread(target=pumpcontrol.start_pumpfor, args=(pump.pin, pumptime))
        pump_thread.start()
        threads.append(pump_thread)

        # Thread für das Aktualisieren des Volumens
        volume_thread = Thread(
            target=update_volume,
            args=(pump.container_id, removedVolume)
        )
        volume_thread.start()
        threads.append(volume_thread)
    return threads     



def update_volume(container_id, removedVolume):
    with threading.Lock():  # Sicherstellen, dass immer nur ein Thread den Codeblock ausführt
        # Kritische Datenbankoperationen oder Änderungen
        Container.Database().updateCurrent_volume(container_id, removedVolume)

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
    ingredients = Ingredient.Database().selectByOrder_id(order.id)

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

def check_steps(recipe_name,orders_id):
    ingredients = Ingredient.Database().selectByOrder_id(orders_id)
    if not ingredients:
        logger.error(f"Keine Zutaten für Rezept ID {orders_id} gefunden.")
        Order.Database().updateStatus(orders_id,4)
        return False
    maxstep =  max([int(ingredient.step) for ingredient in ingredients])
    # Überprüfen, ob alle Schritte im Rezept Zutaten haben
    for step in range(maxstep + 1):
        logger.debug(f"Überprüfe Schritt {step + 1} für {recipe_name}.")
        ingredient_step = Ingredient.Database().selectByStepandOrder_id(step, orders_id)
        
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
                Order.Database().updateStatus(orders_id, 4)
                return False
            
            containers = Container.Database().selectByLiquid_id(liquid_id)
            # Überprüfen, ob Container für die Flüssigkeit vorhanden sind
            if not containers:
                logger.error(f"Keine Container für Flüssigkeit '{liquid.name}' gefunden. Abbruch!")
                Order.Database().updateStatus(orders_id, 4)
                return False

            # Überprüfen, ob Pumpen für den Container existieren
            pumps = collect_pumps_from_containers(containers)

            if not pumps:
                logger.error(f"Keine Pumpen für Flüssigkeit '{liquid.name}' gefunden. Abbruch!")
                Order.Database().updateStatus(orders_id, 4)
                return False
            
    return True