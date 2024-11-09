from  sqlite4  import  SQLite4

class DBconnect:
    DB_NAME = 'Frontend\\database\\database.sqlite'
    database= SQLite4(DB_NAME)
    database.connect()
