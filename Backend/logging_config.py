import logging

class Logger:
    _instance = None

    def __new__(cls):
        if cls._instance is None:
            # Create the logger only once
            cls._instance = super(Logger, cls).__new__(cls)
            
            # Logger erstellen
            cls._instance.logger = logging.getLogger("Main")
            cls._instance.logger.setLevel(logging.DEBUG)

            # Weiterleitung an Root-Logger deaktivieren
            cls._instance.logger.propagate = False

            # StreamHandler für die Konsole
            console_handler = logging.StreamHandler()
            console_handler.setLevel(logging.DEBUG)
            console_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))

            # FileHandler für alle Logs
            file_handler = logging.FileHandler("application.log", encoding="utf-8", mode='w')
            file_handler.setLevel(logging.INFO)
            file_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))
            cls._instance.logger.addHandler(file_handler)

            # FileHandler für Fehler-Logs
            error_handler = logging.FileHandler("errors.log", encoding="utf-8", mode='w')
            error_handler.setLevel(logging.ERROR)
            error_handler.setFormatter(logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s'))

            # Handlers zum Logger hinzufügen
            cls._instance.logger.addHandler(console_handler)
            cls._instance.logger.addHandler(error_handler)

        return cls._instance

    def get_logger(self, name):
        return self.logger.getChild(name)

