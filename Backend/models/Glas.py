from dataclasses import dataclass
from models import DBconnect

@dataclass
class Glas:
    id:int
    name:str
    image:str
    volume:int
    
class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'glasses'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Glas(id=row[0], name=row[1], image=row[2],volume=row[3]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Glas(id=first[0], name=first[1], image=first[2], volume=first[3])
        else: 
            return None