from  sqlite4  import  SQLite4
from dataclasses import dataclass

@dataclass
class Container:
    id:int
    liquid_id:int
    volume:int
    current_volume:int



class Database:
    
    TABLE_NAME = 'containers'
    DB_NAME = 'Frontend\\database\\database.sqlite'

    database= SQLite4(DB_NAME)
    database.connect()

    def selectAllFromDatabase(self): 
        data = self.database.select(self.TABLE_NAME)
        containers = []
        for container in data:
            containers.append(Container(id=container[0], liquid_id=container[1], volume=container[2], current_volume=container[3]))
        return containers
    
    def selectByID(self, id):
        data = self.database.select(self.TABLE_NAME,condition=f'id = {id}')
        first=data[0]
        return Container(id=first[0], liquid_id=first[1], volume=first[2], current_volume=first[3])
