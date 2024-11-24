from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'liquids'

# Datenmodell für Liquid
@dataclass
class Liquid(DBconfig.DBclass):
    name:str
    alternative_name:Optional[str]
    alcoholic:int
    image:Optional[str]
    color:str
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    

class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Liquid)
    
    #Gibt einen Eintrag anhand der ID zurück. 
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Liquid, id)

