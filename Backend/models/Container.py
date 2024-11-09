from dataclasses import dataclass
try:
    from models import DBconnect
except:
    import DBconnect

@dataclass
class Container:
    id:int
    liquid_id:int
    volume:int
    current_volume:int



class Database(DBconnect.DBconnect):
    
    TABLE_NAME = 'containers'
    
    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        return [Container(id=row[0], liquid_id=row[1], volume=row[2],current_volume=row[3]) for row in data]
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        if (len(data)>0):
            first=data[0]
            return Container(id=first[0], liquid_id=first[1], volume=first[2], current_volume=first[3])
        else: 
            return None

print(Database().selectAllFromDatabase())