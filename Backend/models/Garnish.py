from dataclasses import dataclass
from datetime import datetime
from typing import Optional
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'garnishes'

@dataclass
class Garnish(DBconfig.DBclass):
    name:str
    description: Optional[str]
    image:Optional[str]
    created_at:Optional[datetime]
    updated_at:Optional[datetime]

class Database(DBconfig.DBconnect):
    
    

    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Garnish)
    
    def selectByID(self, id):
         return self.selectByIDFromTable(TABLE_NAME, Garnish, id)
