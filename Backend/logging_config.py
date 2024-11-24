import logging

# Logger erstellen
logger = logging.getLogger("Main")
logger.setLevel(logging.DEBUG)

# Weiterleitung an Root-Logger deaktivieren
logger.propagate = False

# StreamHandler für die Konsole
console_handler = logging.StreamHandler()
console_handler.setLevel(logging.INFO)
console_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))

#FileHandler für alle Logs
file_handler = logging.FileHandler("application.log", encoding="utf-8", mode='w')
file_handler.setLevel(logging.DEBUG)
file_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))
logger.addHandler(file_handler)

# FileHandler für Fehler-Logs
error_handler = logging.FileHandler("errors.log", encoding="utf-8",mode='w')
error_handler.setLevel(logging.ERROR)
error_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))

# Handlers zum Logger hinzufügen
logger.addHandler(console_handler)
logger.addHandler(error_handler)

# Funktion zum Abrufen des Loggers
def get_logger(name):
    return logger.getChild(name)