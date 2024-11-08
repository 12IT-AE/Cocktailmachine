import string
from scale import Scale
from pumps import start_pump, stop_pump 
from Cocktail import Cocktail
from IngredientStatus import IngredientStatus



class Mixer:
    def __init__(self, ingredientMap: list):
        """
        :param ingredientMap:
        """
        self.ingredientMap = ingredientMap
        self.Scale = Scale()

    def mixCocktail(self, cocktail: Cocktail):
        print(self.ingredientMap)
        print(cocktail)
        ingredients = list()
        for ing in cocktail.ingredients:
            print('Interating:')
            print(ing)
            cont = False
            for iMap in self.ingredientMap:
                if iMap.name == ing.name:
                    cont = True
                    if(ing.amount > (iMap.fillLevel-10)):
                        print('not enough')
                        raise ValueError("Too Little")
                    ingredients.append(IngredientStatus(fillLevel = ing.amount, name = ing.name, pump = iMap.pump))
                    break
            if not cont:
                print('Missing Ingredient')
                raise ValueError("Missing Ingredients")
        
        for ing in ingredients:
            print('Pouring:')
            print(ing)
            self._pour(ing.fillLevel, ing.pump)

    def _pour(self, amount: int, pump: int):
        print('Taring')
        self.Scale.tare()
        start_pump(pump)
        pumping = True
        print('pumping')
        while pumping:
            weight = self.Scale.weight()
            print(weight)
            if weight >= amount:
                pumping = False
                print('stopping')
                stop_pump(pump)

    def _weigh(self):
        raise ValueError("Not yet implemented")
