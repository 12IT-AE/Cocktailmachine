from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'pumps'

@dataclass
class Pump(DBconfig.DBclass):
    container_id:int
    pin:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime] 


class Database(DBconfig.DBconnect):
    
    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Pump)

    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Pump, id)
    
    def selectPinByContainerID(self, container_id):
        data = self.database.select(TABLE_NAME,condition=f'container_id = {container_id}')
        return [Pump(id=row[0], container_id=row[1], pin=row[2],created_at=row[3],updated_at=[4]) for row in data]


     