import time
from models import Order,Ingredient,Liquid,Order,Recipe
from datetime import datetime

def checkOrders():
    pending = Order.Database().selectFirstByStatus(0)
    processing = Order.Database().selectFirstByStatus(1)
    if not pending and not processing:
        time.sleep(2)
        checkOrders() # recursive call
    
    if processing not in [None, []]:

        recipe_id = processing.recipe_id
        recipe = Recipe.Database().selectByID(recipe_id)
        print(recipe.name)
        ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)

        for ingredient in ingredients:
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
now = datetime.now()
Order.Database().insertOrder(0,1,now,now)
checkOrders()
