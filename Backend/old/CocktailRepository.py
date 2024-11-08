from tinydb import TinyDB, Query
from CocktailIngredient import CocktailIngredient
from Cocktail import Cocktail


def convertDbRowToCocktailModel(row):
    if row is None:
        return None
    ingredients = []
    for ingredient in row['ingredients']:
        ingredient_model = CocktailIngredient(name=ingredient['name'], amount=ingredient['amount'])
        ingredients.append(ingredient_model)
    cocktail_model = Cocktail(name=row['name'], ingredients=ingredients)
    return cocktail_model


class CocktailRepository:
    db: TinyDB
    query: Query

    def __init__(self):
        self.db = TinyDB('data/cocktails.json')
        self.query = Query()

    def saveCocktail(self, cocktail: Cocktail):
        ingredients_data = []
        for ingredient in cocktail.ingredients:
            ingredients_data.append(ingredient.__dict__)

        cocktail_data = {
            'name': cocktail.name,
            'ingredients': ingredients_data,
        }
        self.db.insert(cocktail_data)

    def saveOrUpdateCocktail(self, cocktail: Cocktail):
        old_cocktail = self.getByName(cocktail.name)
        if old_cocktail is not None:
            self.deleteCocktail(old_cocktail)
        self.saveCocktail(cocktail)

    def getCocktails(self) -> list[Cocktail]:
        rows = self.db.all()
        data = []
        for row in rows:
            data.append(convertDbRowToCocktailModel(row))
        return data

    def deleteCocktail(self, cocktail: Cocktail):
        self.db.remove(self.query.name == cocktail.name)

    def getByName(self, name: str):
        results = self.db.search(self.query.name == name)
        if len(results) == 0:
            return None
        return convertDbRowToCocktailModel(results[00])
