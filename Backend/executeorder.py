import time
from models import Ingredient,Order,Recipe,Container,Pump,Liquid
import pumpcontrol
from threading import Thread

def executeOrders(order):
    recipe_id = order.recipe_id
    recipe = Recipe.Database().selectByID(recipe_id)
    if not recipe:
        print(f"Rezept mit ID {recipe_id} nicht gefunden!")
        return
    print(f"{recipe.name} wird zubereitet")
    ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)
    if not ingredients:
        print(f"Keine Zutaten für Rezept ID {recipe_id} gefunden.")
        return
    maxstep =  max([int(ingredient.step) for ingredient in ingredients])
    # Schritte des Rezepts durchlaufen
    for step in range(maxstep+1):
        step = int(step)  # Sicherstellen, dass step ein Integer ist
        print(f"Starte Schritt {step + 1} für {recipe.name}.")
        ingredient_step =  Ingredient.Database().selectByStepandRecipe_id(step,recipe_id)
        if not ingredient_step:
            print(f"Keine Zutaten für Schritt {step + 1} gefunden. Überspringe.")
            continue

        pumptimelist = [] 
                    
        # Bearbeite alle Zutaten im aktuellen Schritt
        for ingredient in ingredient_step:
            containers = Container.Database().selectByLiquid_id(ingredient.liquid_id)
            liquid = Liquid.Database().selectByID(ingredient.liquid_id)
            if not liquid:
                print(f"Fehler: Flüssigkeit mit ID {ingredient.liquid_id} nicht gefunden. Überspringe.")
                continue
            if not containers:
                print(f"Warnung: Keine Container für Flüssigkeit '{liquid.name}' gefunden. Überspringe.")
                continue
            pumps = collect_pumps_from_containers(containers)
            
            if not pumps:
                print(f"Warnung: Keine Pumpen für Flüssigkeit '{liquid.name}' gefunden. Überspringe.")
                continue
            pumptime = distribute_ingredient_among_pumps(pumps, ingredient.amount, liquid.name)
            pumptimelist.append(pumptime)

        maxtime = max(pumptimelist) if pumptimelist else 0
        # Warten, bis alle Pumpen abgeschlossen sind    
        time.sleep(maxtime+2)   
        print(f"Step {step+1} von {maxstep+1} abgeschlossen")
    
    # Bestellung abschließen
    Order.Database().updateStatus(order.id,2)
    print(f"{recipe.name} ist fertig")

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

    amount_per_pump = amount / len(pumps)
    print(f"Verteile {amount} ml Flüssigkeit '{liquid_name}' auf {len(pumps)} Pumpe(n).")
    # Die maximale Zeit, die für das Abpumpen benötigt wird
    pumptime = getTime(amount_per_pump)
    for pump in pumps:
        Thread(target=pumpcontrol.start_pumpfor, args=(pump.pin, getTime(amount_per_pump))).start()
        Thread(
            target=Container.Database().updateCurrent_volume,
            args=(pump.container_id, amount_per_pump),
        ).start()
    return pumptime 



#Berechnet die Laufzeit der Pumpe basierend auf der Menge.
def getTime(amount):
    flow_rate = 20  # Durchflussrate in ml/s
    return amount/flow_rate
