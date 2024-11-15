from  sqlite4  import  SQLite4
from dataclasses import dataclass

@dataclass
class DBclass:
    id:int

class DBconnect:
    DB_NAME = 'Frontend\\database\\database.sqlite'
    database= SQLite4(DB_NAME)
    database.connect()

    def selectAllFromTable(self,table_name,model_class): 
        data = self.database.select(table_name)
        return [model_class(*row) for row in data]
    
    def selectByIDFromTable(self, table_name, model_class, id):
        data = self.database.select(table_name, condition=f'id = {id}')
        if data:
            return model_class(*data[0])
        else:
            return None
