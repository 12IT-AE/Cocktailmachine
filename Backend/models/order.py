import sqlite3
from dataclasses import dataclass

@dataclass
class Order:
    id:int 
    recipe_id:int
    status:int