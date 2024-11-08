from pydantic import BaseModel


class CocktailIngredient(BaseModel):
    name: str
    amount: int

