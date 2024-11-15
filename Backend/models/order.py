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

    def selectFirstByStatus(self, status):
        data = self.database.select(TABLE_NAME,condition=f'status = {status}')
        if (len(data)>0):
            first=data[0]
            return Order(id=first[0], recipe_id=first[1], status=first[2],created_at=first[3],updated_at=first[4])
        else: 
            return None
    
    def updateStatus(self,id,newstatus):
        self.updateStatusFromTable(self,id,newstatus,TABLE_NAME)

    def insertOrder(self,status,recipe_id,created_at,updated_at):
        self.database.insert(TABLE_NAME, {'status': status, 'recipe_id': recipe_id, 'created_at': created_at, 'updated_at': updated_at})