from dataclasses import dataclass
from typing import Optional
try:
    from models import DBconnect
except:
    import DBconnect

@dataclass
class Recipe:
    id:int 
    glass_id:int
    name:str
    description: Optional[str]
    ice:bool

class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'recipes'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Recipe(id=row[0], glass_id=row[1],name=row[2],description=row[3],ice=row[4]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Recipe(id=first[0], glass_id=first[1],name=first[2],description=first[3],ice=first[4])
        else: 
            return None
