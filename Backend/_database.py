import sqlite4

def init():
    database = sqlite4.SQLite4('../Frontend/database/database.sqlite')
    database.connect()

    return database
