import time
from  sqlite4  import  SQLite4


database= SQLite4('../Frontend/database/database.sqlite')
database.connect()


def checkOrders():
    pending = database.select("orders", condition='status = "0"')
    processing = database.select("orders", condition="status = 1")

    if not pending and not processing:
        time.sleep(2)
        checkOrders() # recursive call
    
    if processing not in [None, []]:
        recipe_id = processing[0][2]
        recipe = database.select("recipes", condition=f'id = {recipe_id}')
        print(recipe[0][2])
        ingredients = database.select("ingredients", condition=f'id = {recipe_id}')
        for ingredient in ingredients:
            liquid = database.select("liquids", condition=f'id = {ingredient[2]}')

            liquid_id = ingredient[2]

            amount = ingredient[4]
            print(f"Zapfe {liquid[0][1]} mit {amount} Ml")

        time.sleep(10)
        database.update("orders", {"status": "2"}, f"id = {processing[0][0]}")
        print(processing[0])
        checkOrders()
    


    for order in pending:
        print(order)
        database.update("orders", {"status": "1"}, f"id = {order[0]}")
        
    checkOrders() # recursive call

database.insert('orders', {'status': 0, 'recipe_id': 1, 'created_at': "2021-06-01 12:00:00", 'updated_at': "2021-06-01 12:00:00"})
checkOrders()