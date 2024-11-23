from  sqlite4  import  SQLite4
from dataclasses import dataclass
from datetime import datetime

# Definition der Basisklasse für alle Datenbankobjekte
@dataclass
class DBclass:
    id:int

class DBconnect:
    try:
        DB_NAME = '../Frontend/database/database.sqlite'
        database= SQLite4(DB_NAME)
        database.connect()
    except:
        DB_NAME = 'Frontend\\database\\database.sqlite'
        database= SQLite4(DB_NAME)
        database.connect()


    def _selectAllFromTable(self,table_name,model_class): 
        data = self.database.select(table_name)
        return [model_class(*row) for row in data]
    
    def _selectByIDFromTable(self, table_name, model_class, id):
        data = self.database.select(table_name, condition=f'id = {id}')
        if len(data)>0:
            return model_class(*data[0])
        else:
            return None
        
    def _updateStatusFromTable(self,id,newstatus,table_name):
        updated_at = datetime.now().strftime('%Y-%m-%d %H:%M:%S')  # Format für SQL
        self.database.update(table_name, {"status": f"{newstatus}","updated_at":f"{updated_at}"}, f"id = {id}")

    def _selectByColoumnFromTable(self,table_name,model_class,column,value):
        data = self.database.select(table_name,condition=f'{column} = {value}')
        return [model_class(*(row)) for row in data]

 
