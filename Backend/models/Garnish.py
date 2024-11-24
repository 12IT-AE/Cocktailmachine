from dataclasses import dataclass
from datetime import datetime
from typing import Optional
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'garnishes'

# Datenmodell für Garnish
@dataclass
class Garnish(DBconfig.DBclass):
    name:str
    description: Optional[str]
    image:Optional[str]
    created_at:Optional[datetime]
    updated_at:Optional[datetime]

class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Garnish)
    
    #Gibt einen Eintrag anhand der ID zurück.       
    def selectByID(self, id):
         return self._selectByIDFromTable(TABLE_NAME, Garnish, id)
