from datetime import datetime
from typing import Optional
from dataclasses import dataclass
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'containers'

@dataclass
class Container(DBconfig.DBclass):
    liquid_id:int
    volume:int
    current_volume:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]


class Database(DBconfig.DBconnect):
    
    
    
    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Container)
    
    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Container, id)
