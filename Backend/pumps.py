import time, logging

from models import Pump

import Mock.GPIO as GPIO

pump_db = Pump.Database()
#pumps = [7, 11, 13, 15, 16, 18, 35, 37]

def start_pump(container_id):
    print(f"Start Pump: {container_id}")
    gpio_pin = pump_db.selectPinByContainerID(container_id) 
    if gpio_pin is not None:
        GPIO.setmode(GPIO.BCM)
        logging.info(f"GPIO {gpio_pin}: starting")
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, GPIO.LOW)
    else:
        logging.error(f"GPIO Pin für Pumpen-Container-ID {container_id} nicht gefunden!")

def stop_pump(container_id):
    print(f"Stop Pump: {container_id}")
    gpio_pin = pump_db.selectPinByContainerID(container_id)
    if gpio_pin is not None:
        GPIO.setmode(GPIO.BCM)
        logging.info(f"GPIO {gpio_pin}: stopping!")
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, GPIO.HIGH)
    else:
        logging.error(f"GPIO Pin für Pumpen-Container-ID {container_id} nicht gefunden!")

def cleanPumps():
    all_pumps = pump_db.selectAllFromDatabase()
    for pump in all_pumps:
        gpio_pin = pump.pin
        if gpio_pin is not None:
            logging.info(f"GPIO {gpio_pin}: cleaning")
            GPIO.setup(gpio_pin, GPIO.OUT)
            GPIO.output(gpio_pin, GPIO.LOW)
        else:
            logging.error(f"GPIO Pin für Pumpen-Container-ID {pump.container_id} nicht gefunden!")

    time.sleep(30)

    for pump in all_pumps:
        gpio_pin = pump.pin
        if gpio_pin is not None:
            GPIO.setup(gpio_pin, GPIO.OUT)
            GPIO.output(gpio_pin, GPIO.HIGH)
        else:
            logging.error(f"GPIO Pin für Pumpen-Container-ID {pump.container_id} nicht gefunden!")

if __name__ == "__main__":
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    cleanPumps()
    GPIO.cleanup()

