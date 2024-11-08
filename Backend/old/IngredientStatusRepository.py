from tinydb import TinyDB, Query
from IngredientStatus import IngredientStatus


def convertDbRowToIngredientStatusModel(row):
    if row is None:
        return None
    ingredient_status_model = IngredientStatus(name=row['name'], pump=row['pump'], fillLevel=row['fillLevel'])
    return ingredient_status_model


class IngredientStatusRepository:
    db: TinyDB
    query: Query

    def __init__(self):
        self.db = TinyDB('data/ingredient_status.json')
        self.query = Query()

    def saveIngredientStatus(self, ingredient_status: IngredientStatus):
        ingredient_status_data = {
            'name': ingredient_status.name,
            'pump': ingredient_status.pump,
            'fillLevel': ingredient_status.fillLevel
        }
        self.db.insert(ingredient_status_data)

    def saveOrUpdateIngredientStatus(self, ingredient_status: IngredientStatus):
        old_ingredient_status = self.getByName(ingredient_status.name)
        if old_ingredient_status is not None:
            self.deleteIngredientStatus(old_ingredient_status)
        self.saveIngredientStatus(ingredient_status)

    def deleteIngredientStatus(self, ingredient_satus: IngredientStatus):
        self.db.remove(self.query.name == ingredient_satus.name)

    def getIngredientStatus(self):
        rows = self.db.all()
        data = []
        for row in rows:
            data.append(convertDbRowToIngredientStatusModel(row))
        return data

    def getByName(self, name: str):
        results = self.db.search(self.query.name == name)
        if len(results) == 0:
            return None
        return convertDbRowToIngredientStatusModel(results[00])

    def getByPump(self, pump: int):
        results = self.db.search(self.query.pump == pump)
        if len(results) == 0:
            return None
        return convertDbRowToIngredientStatusModel(results[00])
