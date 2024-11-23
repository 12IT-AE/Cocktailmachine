import time, logging

from models import Pump
try: 
    import RPi.GPIO as GPIO
except:
    import Mock.GPIO as GPIO

# Initialisiere GPIO Pin
def setup_gpio(pin, state):
    if pin is not None:
        GPIO.setup(pin, GPIO.OUT)
        GPIO.output(pin, state)
    else:
        logging.error(f"GPIO {pin} ist ungültig!")

# Startet die Pumpe
def start_pump(gpio_pin):
    print(f"Start Pump: {gpio_pin}")
    if gpio_pin is not None:
        logging.info(f"GPIO {gpio_pin}: starting")
        setup_gpio(gpio_pin, GPIO.LOW)
    else:
        logging.error(f"GPIO {gpio_pin} nicht gefunden!")

# Stoppt die Pumpe
def stop_pump(gpio_pin):
    print(f"Stop Pump: {gpio_pin}")
    if gpio_pin is not None:
        logging.info(f"GPIO {gpio_pin}: stopping!")
        setup_gpio(gpio_pin, GPIO.HIGH)
    else:
        logging.error(f"GPIO {gpio_pin} nicht gefunden!")

def cleanPumps(sec):
    all_pumps = Pump.Database().selectAllFromDatabase()
    if not all_pumps:
        logging.warning("Keine Pumpen in der Datenbank gefunden!")
        return
    print("Starte Reinigung aller Pumpen...")
    for pump in all_pumps:
        if pump.pin is not None:
            print(f"Reinige Pumpe GPIO {pump.pin}")
            setup_gpio(pump.pin, GPIO.LOW)
        else:
            logging.error(f"GPIO {pump.pin} nicht gefunden!")

    time.sleep(sec)

    for pump in all_pumps:
        if pump.pin is not None:
            setup_gpio(pump.pin, GPIO.HIGH)
    print(f"Reinigung abgeschlossen!")

# Startet eine Pumpe für eine bestimmte Dauer
def start_pumpfor(gpio_pin, sec):
    if gpio_pin is None:
        print("Ungültiger GPIO-Pin! Vorgang abgebrochen.")
        return
    GPIO.setmode(GPIO.BCM)
    start_pump(gpio_pin)
    time.sleep(sec)
    stop_pump(gpio_pin)


if __name__ == "__main__":
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    cleanPumps(3)
    GPIO.cleanup()