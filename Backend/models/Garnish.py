from  sqlite4  import  SQLite4
from dataclasses import dataclass
from typing import List, Optional

@dataclass
class Garnish:
    id:int 
    name:str
    description: Optional[str]
    image:Optional[str]

