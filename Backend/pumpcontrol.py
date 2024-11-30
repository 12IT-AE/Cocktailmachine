import time, logging
from models import Pump
try: 
    import RPi.GPIO as GPIO
except ImportError:
    import Mock.GPIO as GPIO

from logging_config import Logger

logger_singleton = Logger()
logger = logger_singleton.get_logger(__name__)

# Initialisiere GPIO Pin
def setup_gpio(gpio_pin, state):
    if gpio_pin is not None:
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, state)
        action = "starting" if state == GPIO.LOW else "stopping"
        logger.debug(f"GPIO {gpio_pin}: {action}")

def cleanPumps(sec):
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    all_pumps = Pump.Database().selectAllFromDatabase()
    if not all_pumps:
        logger.warning("Keine Pumpen in der Datenbank gefunden!")
        return
    logger.info("Starte Reinigung aller Pumpen...")
    for pump in all_pumps:
        logger.debug(f"Reinige Pumpe GPIO {pump.pin}")
        setup_gpio(pump.pin, GPIO.LOW)

    time.sleep(sec)

    for pump in all_pumps:
        setup_gpio(pump.pin, GPIO.HIGH)
    logger.debug(f"Reinigung abgeschlossen!")

# Startet eine Pumpe für eine bestimmte Dauer
def start_pumpfor(gpio_pin, sec):
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    if gpio_pin is None:
        logger.error("Ungültiger GPIO-Pin! Vorgang abgebrochen.")
        return
    setup_gpio(gpio_pin, GPIO.LOW)
    time.sleep(sec)
    setup_gpio(gpio_pin, GPIO.HIGH)


if __name__ == "__main__":
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    cleanPumps(3)
    GPIO.cleanup()