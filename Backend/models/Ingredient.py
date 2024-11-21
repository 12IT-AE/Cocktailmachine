from dataclasses import dataclass
from operator import attrgetter
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'ingredients'

@dataclass
class Ingredient(DBconfig.DBclass):
    recipe_id:int
    liquid_id:int
    step:int
    amount:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    
class Database(DBconfig.DBconnect):
    
    

    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, Ingredient)
    
    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, Ingredient, id)
        
    def selectByRecipe_id(self, recipe_id):
        data = self.database.select(TABLE_NAME,condition=f'recipe_id = {recipe_id}')
        return [Ingredient(id=row[0], recipe_id=row[1], liquid_id=row[2],step=row[3],amount=row[4],created_at=[5],updated_at=[6]) for row in data]
        
    def selectByStep(self, step):
        data = self.database.select(TABLE_NAME,condition=f'step = {step}')
        return [Ingredient(id=row[0], recipe_id=row[1], liquid_id=row[2],step=row[3],amount=row[4],created_at=[5],updated_at=[6]) for row in data]
        

