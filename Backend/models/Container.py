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

    def selectByLiquid_id(self, recipe_id):
        data = self.database.select(TABLE_NAME,condition=f'liquid_id = {recipe_id}')
        return [Container(id=row[0], liquid_id=row[1], volume=row[2],current_volume=row[3],created_at=[4],updated_at=[5]) for row in data]
        