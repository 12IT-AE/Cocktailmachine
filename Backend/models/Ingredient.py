import sqlite3
from dataclasses import dataclass

@dataclass
class Ingredient:
    id:int 
    recipe_id:int
    liquid_id:int
    step:int
    amount:int
