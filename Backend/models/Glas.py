from  sqlite4  import  SQLite4
from dataclasses import dataclass

@dataclass
class Glas:
    id:int
    name:str
    image:str
    volume:int
    
