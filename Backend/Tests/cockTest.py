from IngredientStatus import IngredientStatus
from database.models import Cocktail
from Mixer import Mixer
import RPi.GPIO as GPIO

GPIO.cleanup()

maps = list()
f1 = IngredientStatus("1", 0, 100)
f2 = IngredientStatus("2", 1, 5)
f3 = IngredientStatus("3", 2, 100)
f4 = IngredientStatus("4", 3, 100)
f5 = IngredientStatus("5", 4, 100)
f6 = IngredientStatus("6", 5, 100)
f7 = IngredientStatus("7", 6, 100)
f8 = IngredientStatus("8", 7, 100)


maps.append(f1)
maps.append(f2)
maps.append(f3)
maps.append(f4)
maps.append(f5)
maps.append(f6)
maps.append(f7)
maps.append(f8)

ingredients = dict()

ingredients["1"] = 10
ingredients["2"] = 10
ingredients["3"] = 10
ingredients["4"] = 10
ingredients["5"] = 10
ingredients["6"] = 10
ingredients["7"] = 10
ingredients["8"] = 10

cocktail = Cocktail("Test",ingredients) 

mixer = Mixer(maps)



mixer.mixCocktail(cocktail)


