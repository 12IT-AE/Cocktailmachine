from pydantic import BaseModel


class IngredientStatus(BaseModel):
    name: str
    pump: int
    fillLevel: int
