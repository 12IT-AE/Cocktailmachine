from dataclasses import dataclass
from typing import Optional
from models import DBconnect

@dataclass
class Liquid:
    id:int 
    name:str
    alternative_name:Optional[str]
    alcoholic:int
    image:Optional[str]
    color:str

class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'liquids'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Liquid(id=row[0], name=row[1], alternative_name=row[2],alcoholic=row[3],image=row[4],color=row[4]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Liquid(id=first[0], name=first[1], alternative_name=first[2], alcoholic=first[3],image=first[4],color=first[5])
        else: 
            return None

