from dataclasses import dataclass
try:
    from models import DBconnect
except:
    import DBconnect

@dataclass
class Pump:
    id:int 
    container_id:int
    #+ Vielleicht Pin auf Raspberry 


class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'garnishes'

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Pump(id=row[0], container_id=row[1]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Pump(id=first[0], container_id=first[1])
        else: 
            return None
