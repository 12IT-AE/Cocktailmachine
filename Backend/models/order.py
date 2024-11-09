from dataclasses import dataclass
from typing import Optional
from datetime import datetime
from models import DBconnect

@dataclass
class Order:
    id:int 
    recipe_id:int
    status:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]

class Database(DBconnect.DBconnect):

    TABLE_NAME = 'orders'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Order(id=row[0], recipe_id=row[1], status=row[2],created_at=row[3],updated_at=row[4]) for row in data]

    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Order(id=first[0], recipe_id=first[1], status=first[2],created_at=first[3],updated_at=first[4])
        else: 
            return None

    def selectFirstByStatus(self, status):
        data = self.database.select(self.TABLE_NAME,condition=f'status = {status}')
        if (len(data)>0):
            first=data[0]
            return Order(id=first[0], recipe_id=first[1], status=first[2],created_at=first[3],updated_at=first[4])
        else: 
            return None
    
    def updateStatus(self,id,newstatus):
        self.database.update("orders", {"status": f"{newstatus}"}, f"id = {id}")

    def insertOrder(self,status,recipe_id,created_at,updated_at):
        self.database.insert('orders', {'status': status, 'recipe_id': recipe_id, 'created_at': created_at, 'updated_at': updated_at})