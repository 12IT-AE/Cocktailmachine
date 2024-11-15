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
        pump = self.selectByID(container_id)
        if pump:
            return Pump.pin
        return None
    
