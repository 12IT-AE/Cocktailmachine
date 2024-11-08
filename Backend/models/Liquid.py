from  sqlite4  import  SQLite4
from dataclasses import dataclass
from typing import Optional

@dataclass
class Liquid:
    id:int 
    name:str
    alternative_name:Optional[str]
    alcoholic:int
    image:Optional[str]
    color:str

class Database:
    
    TABLE_NAME = 'liquids'
    DB_NAME = 'Frontend\\database\\database.sqlite'

    database= SQLite4(DB_NAME)
    database.connect()

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        liquids = []
        for liquid in data:
            liquids.append(Liquid(id=liquid[0], name=liquid[1], alternative_name=liquid[2], alcoholic=liquid[3],image=liquid[4],color=liquid[5]))
        return liquids
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        first=data[0]
        return Liquid(id=first[0], name=first[1], alternative_name=first[2], alcoholic=first[3],image=first[4],color=first[5])
    

