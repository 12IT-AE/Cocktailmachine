from dataclasses import dataclass
from typing import Optional
try:
    from models import DBconnect
except:
    import DBconnect


@dataclass
class Garnish:
    id:int 
    name:str
    description: Optional[str]
    image:Optional[str]

class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'garnishes'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Garnish(id=row[0], name=row[1], description=row[2],image=row[3]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Garnish(id=first[0], name=first[1], description=first[2], image=first[3])
        else: 
            return None
