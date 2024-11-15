from dataclasses import dataclass
try:
    from models import DBconfig
except:
    import DBconfig

TABLE_NAME = 'recipe_garnish'

@dataclass
class RecipeGarnish(DBconfig.DBclass):
    recipe_id:int
    garnish_id:int

class Database(DBconfig.DBconnect):
    
    def selectAllFromDatabase(self): 
        return self.selectAllFromTable(TABLE_NAME, RecipeGarnish)
       
    def selectByID(self, id):
        return self.selectByIDFromTable(TABLE_NAME, RecipeGarnish, id)

