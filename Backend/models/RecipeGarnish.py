from dataclasses import dataclass
from models import DBconnect
from typing import Optional

@dataclass
class RecipeGarnish:
    id:int 
    recipe_id:int
    garnish_id:int

class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'recipe_garnish'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [RecipeGarnish(id=row[0], recipe_id=row[1],garnish_id=row[2]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return RecipeGarnish(id=first[0], recipe_id=first[1],garnish_id=first[2])
        else: 
            return None
