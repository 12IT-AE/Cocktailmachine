from dataclasses import dataclass
from operator import attrgetter
try:
    from models import DBconnect
except:
    import DBconnect

@dataclass
class Ingredient:
    id:int 
    recipe_id:int
    liquid_id:int
    step:int
    amount:int


class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'ingredients'

    def selectAllFromDatabase(self): 
        data = self.self.database.select(self.TABLE_NAME)
        return [Ingredient(id=row[0], recipe_id=row[1], liquid_id=row[2],step=row[3],amount=row[4]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Ingredient(id=first[0], recipe_id=first[1], liquid_id=first[2], step=first[3],amount=first[4])
        else: 
            return None
        
    def selectByRecipe_id(self, recipe_id):
        data = self.database.select(self.TABLE_NAME,condition=f'recipe_id = {recipe_id}')
        return sorted([Ingredient(id=row[0], recipe_id=row[1], liquid_id=row[2],step=row[3],amount=row[4]) for row in data], key= attrgetter('step')) 
        

