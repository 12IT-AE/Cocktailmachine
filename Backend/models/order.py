from  sqlite4  import  SQLite4
from dataclasses import dataclass
from typing import Optional
from datetime import datetime

@dataclass
class Order:
    id:int 
    recipe_id:int
    status:int
    updated_at:Optional[datetime]

class Database:

    TABLE_NAME = 'orders'
    DB_NAME = 'Frontend\\database\\database.sqlite'

    database= SQLite4(DB_NAME)
    database.connect()

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        orders = []
        for order in data:
            orders.append(Order(id=order[0], recipe_id=order[1], status=order[2],updated_at=order[4]))
        return orders

    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        first=data[0]
        return Order(id=first[0], recipe_id=first[1], status=first[2],updated_at=first[4])

    def selectFirstByStatus(self, status):
        data = self.database.select(self.TABLE_NAME,condition=f'status = {status}')
        if (len(data)>0):
            first=data[0]
            return Order(id=first[0], recipe_id=first[1], status=first[2],updated_at=first[4])
        else: 
            return None
    
    def updateStatus(self,id,newstatus):
        self.database.update("orders", {"status": f"{newstatus}"}, f"id = {id}")

    def insertOrder(self,status,recipe_id,created_at,updated_at):
        
        self.database.insert('orders', {'status': status, 'recipe_id': recipe_id, 'created_at': created_at, 'updated_at': updated_at})