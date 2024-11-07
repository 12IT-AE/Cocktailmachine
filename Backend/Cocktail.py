from pydantic import BaseModel
from CocktailIngredient import CocktailIngredient


class Cocktail(BaseModel):
    name: str
    ingredients: list[CocktailIngredient]


