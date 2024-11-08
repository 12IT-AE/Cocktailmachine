from  sqlite4  import  SQLite4
from dataclasses import dataclass
from operator import attrgetter

@dataclass
class Ingredient:
    id:int 
    recipe_id:int
    liquid_id:int
    step:int
    amount:int


class Database:
    
    TABLE_NAME = 'ingredients'
    DB_NAME = 'Frontend\\database\\database.sqlite'

    database= SQLite4(DB_NAME)
    database.connect()

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Ingredient(id=row[0], recipe_id=row[1], liquid_id=row[2],step=row[3],amount=row[4]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        first=data[0]
        return Ingredient(id=first[0], recipe_id=first[1], liquid_id=first[2], step=first[3],amount=first[4])
    
    def selectByRecipe_id(self, recipe_id):
        data = self.database.select(self.TABLE_NAME,condition=f'recipe_id = {recipe_id}')
        return sorted([Ingredient(id=row[0], recipe_id=row[1], liquid_id=row[2],step=row[3],amount=row[4]) for row in data], key= attrgetter('step')) 


