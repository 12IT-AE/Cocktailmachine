from datetime import datetime
from typing import Optional
from dataclasses import dataclass
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'containers'

# Datenmodell für Container
@dataclass
class Container(DBconfig.DBclass):
    liquid_id:int
    volume:int
    current_volume:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]


class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Container)
    
    #Gibt einen Eintrag anhand der ID zurück. 
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Container, id)

    #Gibt alle Einträge mit einer bestimmten Liquid_id zurück.    
    def selectByLiquid_id(self, liquid_id):
        return self._selectByColoumnFromTable(TABLE_NAME,Container,'liquid_id',liquid_id)

    #Aktualisiert den aktuellen Füllstand eines Eintrags anhand seiner ID und dem ausgegeben Volumen.    
    def updateCurrent_volume(self,id,dispensedVolume):
        curcontainer = self.selectByID(id)
        newVolume = curcontainer.current_volume - dispensedVolume
        self.database.update(TABLE_NAME, {"current_volume": f"{newVolume}","updated_at":f"{datetime.now()}"}, f"id = {id}")