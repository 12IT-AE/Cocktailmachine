from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig


TABLE_NAME = 'glasses'

@dataclass
class Glas(DBconfig.DBclass):
    name:str
    image:str
    volume:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    
class Database(DBconfig.DBconnect):
    
    def selectAllFromDatabase(self):
        return self.selectAllFromTable(TABLE_NAME, Glas)
        
    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Glas, id)
    
print(Database().selectAllFromDatabase())