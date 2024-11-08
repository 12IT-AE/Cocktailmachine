from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from IngredientStatusRepository import IngredientStatusRepository
from CocktailRepository import CocktailRepository
from Cocktail import Cocktail
from IngredientStatus import IngredientStatus
from pumps import cleanPumps
from Mixer import Mixer
import time

app = FastAPI()
origins = ["*"]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

cocktails_repo = CocktailRepository()
ingredient_status_repo = IngredientStatusRepository()


@app.get("/")
async def root():
    return "test"


@app.get("/cocktails")
async def getCocktails():
    return cocktails_repo.getCocktails()


@app.post("/cocktail")
async def saveCocktail(cocktail: Cocktail):
    cocktails_repo.saveOrUpdateCocktail(cocktail)
    return "success"


@app.delete("/cocktail")
async def deleteCocktail(name: str):
    cocktail = cocktails_repo.getByName(name)
    if cocktail is not None:
        cocktails_repo.deleteCocktail(cocktail)
    return "success"


@app.get("/ingredients")
async def getIngredients():
    return ingredient_status_repo.getIngredientStatus()


@app.post("/ingredient")
async def updateIngredients(ingredient_status: IngredientStatus):
    ingredient_status_repo.saveOrUpdateIngredientStatus(ingredient_status)
    return "success"


@app.delete("/ingredient")
async def deleteIngredient(name: str):
    ingredient_status = ingredient_status_repo.getByName(name)
    if ingredient_status is not None:
        ingredient_status_repo.deleteIngredientStatus(ingredient_status)
    return "success"


@app.post("/configuration/clean_pumps")
async def clean():
    cleanPumps()
    return "/configuration/clean_pumps"


@app.post("/start")
async def createCocktail(cocktail: Cocktail):
    status = ingredient_status_repo.getIngredientStatus()
    mixer = Mixer(status)
    for ingredient in cocktail.ingredients:
        found = False
        for stat in status:
            if stat.name == ingredient.name:
                found = True
                stat.fillLevel = stat.fillLevel - ingredient.amount
                ingredient_status_repo.saveOrUpdateIngredientStatus(stat)
        if not found:
            return "Ingredient Missing"

    try:
        mixer.mixCocktail(cocktail)
        print('Mixing')
        time.sleep(3)
    except:
        return "Ingredient Missing"
    return "Success"
