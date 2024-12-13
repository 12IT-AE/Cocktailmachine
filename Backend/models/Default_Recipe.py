from dataclasses import dataclass
from typing import Optional
from datetime import datetime

try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'default_recipes'

# Datenmodell für Recipe
@dataclass
class Recipe(DBconfig.DBclass):
    glass_id:int
    name:str
    description: Optional[str]
    ice:bool
    image:str
    created_at:Optional[datetime]
    updated_at:Optional[datetime] 

class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Recipe)
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Recipe, id)
