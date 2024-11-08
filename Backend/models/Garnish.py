import sqlite3
from dataclasses import dataclass

@dataclass
class Garnish:
    id:int 
    name:str
    description:str
    image:str

