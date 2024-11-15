from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'recipes'

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
    
    

    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Recipe)

    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Recipe, id)

