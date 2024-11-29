from models import Ingredient,Order,Recipe,Container,Pump,Liquid
import pumpcontrol,time
import logging,threading
from threading import Thread


from logging_config import Logger

logger_singleton = Logger()
logger = logger_singleton.get_logger(__name__)

def executeOrders(order):
    recipe_id = order.recipe_id
    recipe = Recipe.Database().selectByID(recipe_id)
    if not recipe:
        logger.error(f"Rezept mit ID {recipe_id} nicht gefunden!")
        Order.Database().updateStatus(order.id,4)
        return
    logger.info(f"{recipe.name} wird zubereitet")
    ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)
    if not ingredients:
        logger.warning(f"Keine Zutaten für Rezept ID {recipe_id} gefunden.")
        return
    maxstep = max([int(ingredient.step) for ingredient in ingredients])
    # Schritte des Rezepts durchlaufen
    for step in range(maxstep+1):
        step = int(step)  # Sicherstellen, dass step ein Integer ist
        logger.info(f"Starte Schritt {step + 1} für {recipe.name}.")
        ingredient_step =  Ingredient.Database().selectByStepandRecipe_id(step,recipe_id)
        if not ingredient_step:
            logger.warning(f"Keine Zutaten für Schritt {step + 1} gefunden. Überspringe.")
            continue

        Threadtimes = [] 
                    
        # Bearbeite alle Zutaten im aktuellen Schritt
        for ingredient in ingredient_step:
            containers = Container.Database().selectByLiquid_id(ingredient.liquid_id)
            liquid = Liquid.Database().selectByID(ingredient.liquid_id)
            if not liquid:
                logger.error(f"Flüssigkeit mit ID {ingredient.liquid_id} nicht gefunden. Überspringe.")
                continue
            if not containers:
                logger.error(f"Keine Container für Flüssigkeit '{liquid.name}' gefunden. Überspringe.")
                continue
            pumps = collect_pumps_from_containers(containers)
            
            if not pumps:
                logger.error(f"Keine Pumpen für Flüssigkeit '{liquid.name}' gefunden. Überspringe.")
                continue
            Threads = distribute_ingredient_among_pumps(pumps, ingredient.amount, liquid.name)
            if Threads:
                Threadtimes.extend(Threads)


        # Warten, bis alle Pumpen abgeschlossen sind
        #logger.info(f"{maxtime}")
        #time.sleep(maxtime)
        #print(maxtime)
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
def distribute_ingredient_among_pumps(pumps, amount, liquid_name):
    threads = []
    amount_per_pump = amount / len(pumps)
    logger.debug(f"Verteile {amount} ml Flüssigkeit '{liquid_name}' auf {len(pumps)} Pumpe(n).")
    # Die maximale Zeit, die für das Abpumpen benötigt wird
    pumptime = getTime(amount_per_pump)
    for pump in pumps:

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

#Berechnet die Laufzeit der Pumpe basierend auf der Menge.
def getTime(amount):
    flow_rate = 20  # Durchflussrate in ml/s
    return amount/flow_rate

def update_volume(container_id, volume):
    with threading.Lock():  # Sicherstellen, dass immer nur ein Thread den Codeblock ausführt
        # Kritische Datenbankoperationen oder Änderungen
        Container.Database().updateCurrent_volume(container_id, volume)
