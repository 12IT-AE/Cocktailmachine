import time
from models import Order,Ingredient,Liquid,Order,Recipe
from datetime import datetime

def executeOrders(order):

    if order not in [None, []]:

        recipe_id = order.recipe_id
        recipe = Recipe.Database().selectByID(recipe_id)
        print(f"{recipe.name} wird zubereitet")
        ingredients = Ingredient.Database().selectByRecipe_id(recipe_id)
        maxstep =  max([ingredient.id for ingredient in ingredients])
        for i in range(maxstep):
            ingredientstep =  Ingredient.Database().selectByStep(i)
            if ingredientstep not in [None, []]:
                for ingredient in ingredientstep:
                    liquid = Liquid.Database().selectByID(ingredient.id)
                    amount = ingredient.amount
                    print(f"Zapfe {liquid.name} mit {amount} ml")
            
        time.sleep(10)
        Order.Database().updateStatus(order.id,2)
        print(order.id)


