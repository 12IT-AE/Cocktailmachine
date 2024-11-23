from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'glasses'

# Datenmodell für Glas
@dataclass
class Glas(DBconfig.DBclass):
    name:str
    image:str
    volume:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    
class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self):
        return self._selectAllFromTable(TABLE_NAME, Glas) 

    #Gibt einen Eintrag anhand der ID zurück.     
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Glas, id)
    
