import time
from  sqlite4  import  SQLite4
from models import Order,Ingredient,Liquid,Order
from datetime import datetime

database= SQLite4('Frontend\\database\\database.sqlite')
database.connect()

def checkOrders():
    pending = Order.Database().selectFirstByStatus(0)
    processing = Order.Database().selectFirstByStatus(1)
    if not pending and not processing:
        time.sleep(2)
        checkOrders() # recursive call
    
    if processing not in [None, []]:
        recipe_id = processing.recipe_id
        recipe = database.select("recipes", condition=f'id = {recipe_id}')
        print(recipe[0][2])
        ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)
        for ingredient in ingredients:
            #liquid = database.select("liquids", condition=f'id = {ingredient[2]}')
            liquid = Liquid.Database().selectByID(ingredient.id)
            amount = ingredient.amount
            print(f"Zapfe {liquid.name} mit {amount} Ml")

        time.sleep(10)
        Order.Database().updateStatus(processing.id,2)
        print(processing.id)
        checkOrders()
    


    if pending not in [None, []]:
        print(pending)
        Order.Database().updateStatus(pending.id,1)
        
    checkOrders() # recursive call

Order.Database().insertOrder(0,1,datetime.now(),datetime.now())
checkOrders()
