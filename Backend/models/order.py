from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'orders'

@dataclass
class Order(DBconfig.DBclass):
    recipe_id:int
    status:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]

class Database(DBconfig.DBconnect):



    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Order)

    def selectByID(self, id):
       return self.selectByIDFromTable(TABLE_NAME, Order, id)

    def selectByStatus(self, status):
        return self.selectByStatusFromTable(TABLE_NAME, Order,status)
    
    def updateStatus(self,id,newstatus):
        self.updateStatusFromTable(id,newstatus,TABLE_NAME,)

    def insertOrder(self,status,recipe_id,created_at,updated_at):
        self.database.insert(TABLE_NAME, {'status': status, 'recipe_id': recipe_id, 'created_at': created_at, 'updated_at': updated_at})