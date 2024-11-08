import sqlite3
from datetime import datetime

class Recipe:
    def __init__(self, id: int):
        self.__id = id
        self.__glass_id = None
        self.__name = None
        self.__description = None
        self.__ice = None
        self.__image = None
        self.__created_at = None
        self.__updated_at = None
        self.load_from_db()  # Lädt initiale Werte aus der Datenbank

    # Verbindet sich zur Datenbank und lädt Daten basierend auf der ID
    def load_from_db(self):
        with sqlite3.connect("database.sqlite") as connection:
            cursor = connection.cursor()
            cursor.execute("""
                SELECT glass_id, name, description, ice, image, created_at, updated_at
                FROM recipes
                WHERE id = ?
            """, (self.__id,))
            row = cursor.fetchone()
            if row:
                (self.__glass_id, self.__name, self.__description,
                 self.__ice, self.__image, self.__created_at, self.__updated_at) = row

    # Speichert Änderungen in einer bestimmten Spalte in der Datenbank
    def save_to_db(self, column, value):
        with sqlite3.connect("database.sqlite") as connection:
            cursor = connection.cursor()
            cursor.execute(f"UPDATE recipes SET {column} = ?, updated_at = ? WHERE id = ?", (value, datetime.now(), self.__id))
            connection.commit()

    # Getter und Setter für die Attribute mit Datenbankintegration

    # Getter und Setter für glass_id
    def get_glass_id(self):
        return self.__glass_id

    def set_glass_id(self, value: int):
        if isinstance(value, int) and value > 0:
            self.__glass_id = value
            self.save_to_db("glass_id", value)
        else:
            print("Ungültiger Wert für Glass-ID. Glass-ID muss eine positive Ganzzahl sein.")

    # Getter und Setter für name
    def get_name(self):
        return self.__name

    def set_name(self, value: str):
        if isinstance(value, str):
            self.__name = value
            self.save_to_db("name", value)
        else:
            print("Ungültiger Wert für Name. Name muss ein String sein.")

    # Getter und Setter für description
    def get_description(self):
        return self.__description

    def set_description(self, value: str):
        if isinstance(value, str) or value is None:
            self.__description = value
            self.save_to_db("description", value)
        else:
            print("Ungültiger Wert für Beschreibung. Beschreibung muss ein String oder None sein.")

    # Getter und Setter für ice
    def get_ice(self):
        return self.__ice

    def set_ice(self, value: int):
        if isinstance(value, int) and (value == 0 or value == 1):
            self.__ice = value
            self.save_to_db("ice", value)
        else:
            print("Ungültiger Wert für Ice. Ice muss entweder 0 oder 1 sein.")

    # Getter und Setter für image
    def get_image(self):
        return self.__image

    def set_image(self, value: str):
        if isinstance(value, str):
            self.__image = value
            self.save_to_db("image", value)
        else:
            print("Ungültiger Wert für Bild. Bild muss ein String sein.")
