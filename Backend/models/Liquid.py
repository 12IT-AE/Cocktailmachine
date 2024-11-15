from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'liquids'

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
    
    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Liquid)
    
    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Liquid, id)

