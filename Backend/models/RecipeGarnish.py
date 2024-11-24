from dataclasses import dataclass

try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'recipe_garnish'

# Datenmodell für RecipeGarnish
@dataclass
class RecipeGarnish(DBconfig.DBclass):
    recipe_id:int
    garnish_id:int

class Database(DBconfig.DBconnect):
    
    #Gibt einen Eintrag anhand der ID zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, RecipeGarnish)
    
    #Gibt einen Eintrag anhand der ID zurück.   
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, RecipeGarnish, id)

