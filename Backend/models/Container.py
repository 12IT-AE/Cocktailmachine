import sqlite3
from dataclasses import dataclass

@dataclass
class Container:
    id:int
    liquid_id:int
    volume:int
    current_volume:int


# create the database helper class
class DatabaseHelper:
    # initialize
    def __init__(self) -> None:
        self.TABLE_NAME = 'containers'
        self.DB_NAME = 'Frontend\database\database.sqlite'
        self.connect = sqlite3.connect(self.DB_NAME)
        self.cursor = self.connect.cursor()

    def selectAllFromDatabase(self): 
        db = self.cursor.execute(f'SELECT * FROM {self.TABLE_NAME}').fetchall()
        Containers = []
        for data in db:
            Containers.append(Container(id=data[0], liquid_id=data[1], volume=data[2], current_volume=data[3]))
        return Containers
    
    def selectByID(self, id):
        data = self.cursor.execute(
            f"SELECT * FROM {self.TABLE_NAME} WHERE id=?", 
            (id,)
        ).fetchone()
        return Container(id=data[0], liquid_id=data[1], volume=data[2], current_volume=data[3])

databaseHelper = DatabaseHelper()
print(databaseHelper.selectAllFromDatabase())
print(databaseHelper.selectByID(id=1))