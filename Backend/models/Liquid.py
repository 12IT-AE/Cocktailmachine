import sqlite3
from dataclasses import dataclass

@dataclass
class Liquid:
    id:int 
    name:str
    alternative_name:str
    alcoholic:int
    image:str
    color:str
