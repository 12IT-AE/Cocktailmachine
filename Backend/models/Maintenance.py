from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig


TABLE_NAME = 'maintenance'

@dataclass
class Maintenance(DBconfig.DBclass):
    pump_id:str
    status:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    
class Database(DBconfig.DBconnect):
    
    def selectAllFromDatabase(self):
        return self.selectAllFromTable(TABLE_NAME, Maintenance)
        
    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Maintenance, id)
    
    def updateStatus(self,id,newstatus):
        self.updateStatusFromTable(id,newstatus,TABLE_NAME)

    def selectFirstByStatus(self, status):
        return self.selectFirstByStatusFromTable(TABLE_NAME, Maintenance,status)