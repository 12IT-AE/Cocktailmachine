from dataclasses import dataclass
from typing import Optional
from datetime import datetime
try:
    from models import DBconfig
except:
    import DBconfig

# Name der Tabelle in der Datenbank
TABLE_NAME = 'orders'

# Datenmodell für Order
@dataclass
class Order(DBconfig.DBclass):
    recipe_id:int
    status:int
    created_at:Optional[datetime]
    updated_at:Optional[datetime]

class Database(DBconfig.DBconnect):


    #Gibt alle Einträge aus der Tabelle zurück.
    def selectAllFromDatabase(self): 
        return self._selectAllFromTable(TABLE_NAME, Order)

    #Gibt einen Eintrag anhand der ID zurück.
    def selectByID(self, id):
       return self._selectByIDFromTable(TABLE_NAME, Order, id)

    #Gibt alle Einträge mit einem bestimmten Status zurück.
    def selectByStatus(self, status):
        return self._selectByColoumnFromTable(TABLE_NAME,Order,'status',status)
    
    #Aktualisiert den Status eines Eintrags anhand seiner ID.
    def updateStatus(self,id,newstatus):
        self._updateStatusFromTable(id,newstatus,TABLE_NAME,)

    #Fügt eine neue Bestellung in die Datenbank ein.
    def insertOrder(self,status,recipe_id):
        current_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        self.database.insert(TABLE_NAME, {
            'status': status,
            'recipe_id': recipe_id, 
            'created_at': current_time, 
            'updated_at': current_time
            })