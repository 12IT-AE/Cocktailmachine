from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'ingredients'

# Datenmodell für Ingredient
@dataclass
class Ingredient(DBconfig.DBclass):
    order_id:int
    liquid_id:int
    step:int
    amount:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]
    
class Database(DBconfig.DBconnect):
    
    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Ingredient)
    
    #Gibt einen Eintrag anhand der ID zurück. 
    def selectByID(self, id):
        return self._selectByIDFromTable(TABLE_NAME, Ingredient, id)
    
    #Gibt alle Einträge mit einer bestimmten Recipe_id zurück.    
    def selectByOrder_id(self, order_id):
        return self._selectByColoumnFromTable(TABLE_NAME,Ingredient,'recipe_id',order_id)

    #Gibt alle Einträge mit einer bestimmten Recipe_id und Step zurück.    
    def selectByStepandOrder_id(self, step,order_id):
        data = self.database.select(TABLE_NAME,condition=f'step = {step} AND order_id ={order_id}')
        return [Ingredient(id=row[0], order_id=row[1], liquid_id=row[2],step=row[3],amount=row[4],created_at=[5],updated_at=[6]) for row in data]
        
