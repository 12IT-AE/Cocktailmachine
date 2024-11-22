import time
from models import Ingredient,Order,Recipe,Container,Pump
import pumpcontrol as pumpcontrol
from threading import Thread

def executeOrders(order):
    recipe_id = order.recipe_id
    recipe = Recipe.Database().selectByID(recipe_id)
    print(f"{recipe.name} wird zubereitet")
    ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)
    maxstep =  max([ingredient.id for ingredient in ingredients])
    for i in range(maxstep):
        ingredientstep =  Ingredient.Database().selectByStepandRecipe_id(i,recipe_id)
        if ingredientstep not in [None, []]:
            maxamount = max(ingredient.amount for ingredient in ingredientstep)
            #Einbau von mehreren Pumpen vllt andere Zeit?
            for ingredient in ingredientstep:
                containers = Container.Database().selectByLiquid_id(ingredient.liquid_id)
                if containers not in [None, []]:
                    pumps = []
                    for container in containers:
                        pumpen = Pump.Database().selectPinByContainerID(container.id)
                        for pump in pumpen:
                            pumps.append(pump)
                    amount = getTime(ingredient.amount)
                for pump in pumps:
                    Thread(target=pumpcontrol.start_pumpfor, args=(pump.pin,amount/len(pumps))).start()
                    Thread(target=Container.Database().updateCurrent_volume, args=(pump.container_id,ingredient.amount/len(pumps))).start()
            time.sleep(getTime(maxamount)+2)   
            print(f"Step {i+1} abgeschlossen")
    
    Order.Database().updateStatus(order.id,2)
    print(f"{recipe.name} ist fertig")

def getTime(amount):
    return amount/20
