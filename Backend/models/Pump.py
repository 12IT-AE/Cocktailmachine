from  sqlite4  import  SQLite4
from dataclasses import dataclass

@dataclass
class Pump:
    id:int 
    container_id:int
    #+ Vielleicht Pin auf Raspberry 
