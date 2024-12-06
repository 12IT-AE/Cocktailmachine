from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'pumps'

# Datenmodell für Pump
@dataclass
class Pump(DBconfig.DBclass):
    container_id:int
    pin:int
    flowrate:float
    created_at:Optional[datetime]
    updated_at:Optional[datetime] 


class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Pump)

    #Gibt einen Eintrag anhand der ID zurück.
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Pump, id)
    
    #Gibt alle Einträge mit einem bestimmten container_id zurück.
    def selectByContainerID(self, container_id):
        return self._selectByColoumnFromTable(TABLE_NAME,Pump,'container_id',container_id)
    
    def insertPump(self,status,pump_id,flowrate):
        current_time = datetime.now()
        self.database.insert(TABLE_NAME, {
            'container_id': pump_id,
            'pin': status,
            'flowrate': flowrate,
            'created_at': current_time,
            'updated_at': current_time
        })
