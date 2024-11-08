import sqlite3
from dataclasses import dataclass

@dataclass
class Pump:
    id:int 
    container_id:int
    #+ Vielleicht Pin auf Raspberry 
