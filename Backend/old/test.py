from Cocktail import Cocktail
from CocktailIngredient import CocktailIngredient
import CocktailRepository

repo = CocktailRepository.CocktailRepository()

cocktail = Cocktail(name = "Pina Colada", ingredients=[{"rum": 200},{"KoCoS Milch": 200}])
repo.saveCocktail(cocktail)


