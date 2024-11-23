from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'maintenance'

# Datenmodell für Maintenance
@dataclass
class Maintenance(DBconfig.DBclass):
    pump_id:str
    status:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    
class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self):
        return self._selectAllFromTable(TABLE_NAME, Maintenance)

    #Gibt einen Eintrag anhand der ID zurück.    
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Maintenance, id)
    
    #Aktualisiert den Status eines Eintrags anhand seiner ID.
    def updateStatus(self,id,newstatus):
        self._updateStatusFromTable(id,newstatus,TABLE_NAME)

    #Gibt alle Einträge mit einem bestimmten Status zurück.
    def selectByStatus(self, status):
        return self._selectByColoumnFromTable(TABLE_NAME,Maintenance,'status',status)
    
    #Fügt einen neuen Maintenance-Eintrag hinzu.
    def insertMaintenance(self, pump_id, status):
        current_time = datetime.now()
        self.database.insert(TABLE_NAME, {
            'pump_id': pump_id,
            'status': status,
            'created_at': current_time,
            'updated_at': current_time
        })