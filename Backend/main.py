import time
import _database as DB
from maintenance import checkForMaintainence


database= DB.init()

def checkOrders():
    checkForMaintainence(database)

    pending = database.select("orders", condition='status = "0" ')
    processing = database.select("orders", condition="status = 1")

    if len(processing) > 0:
        processOrder(processing[0])
    
    if len(pending) > 0 and len(processing) == 0:
        print(f"Processing order: {pending[0][0]}")
        database.update("orders", {"status": "1"}, f"id = {pending[0][0]}")
    
    time.sleep(2)
    checkOrders() # recursive call


def processOrder(order):
        recipe_id = order[1]
        recipe = database.select("recipes", condition=f'id = {recipe_id}')

        ingredients = database.select("ingredients", condition=f'recipe_id = {recipe_id}')
        for ingredient in ingredients:
            liquid_id = ingredient[2]
            liquid = database.select("liquids", condition=f'id = {ingredient[2]}')
            

            amount = ingredient[4]
            print(f"Zapfe {liquid[0][1]} mit {amount} Ml")

        time.sleep(10)
        database.update("orders", {"status": "2"}, f"id = {order[0]}")
        


if __name__ == "__main__":
    database.insert("maintenance", {"status": 0, 'pump_id': 1, "created_at": "2021-06-01 12:00:00", "updated_at": "2021-06-01 12:00:00"})
    database.insert("maintenance", {"status": 0, 'pump_id': 2, "created_at": "2021-06-01 12:00:00", "updated_at": "2021-06-01 12:00:00"})
    database.insert("maintenance", {"status": 0, 'pump_id': 3, "created_at": "2021-06-01 12:00:00", "updated_at": "2021-06-01 12:00:00"})
    database.insert("maintenance", {"status": 0, 'pump_id': 4, "created_at": "2021-06-01 12:00:00", "updated_at": "2021-06-01 12:00:00"})
    database.insert('orders', {'status': 0, 'recipe_id': 3, 'created_at': "2021-06-01 12:00:00", 'updated_at': "2021-06-01 12:00:00"})
    database.insert('orders', {'status': 0, 'recipe_id': 4, 'created_at': "2021-06-01 12:00:00", 'updated_at': "2021-06-01 12:00:00"})
    database.insert('orders', {'status': 0, 'recipe_id': 3, 'created_at': "2021-06-01 12:00:00", 'updated_at': "2021-06-01 12:00:00"})
    checkOrders()