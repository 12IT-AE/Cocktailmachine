import time, logging

from models import Pump

import Mock.GPIO as GPIO
 

def start_pump(gpio_pin):
    print(f"Start Pump: {gpio_pin}")
    if gpio_pin is not None:
        GPIO.setmode(GPIO.BCM)
        logging.info(f"GPIO {gpio_pin}: starting")
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, GPIO.LOW)
    else:
        logging.error(f"GPIO Pin für Pumpen-Container-ID {gpio_pin} nicht gefunden!")

def stop_pump(gpio_pin):
    print(f"Stop Pump: {gpio_pin}")
    if gpio_pin is not None:
        GPIO.setmode(GPIO.BCM)
        logging.info(f"GPIO {gpio_pin}: stopping!")
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, GPIO.HIGH)
    else:
        logging.error(f"GPIO Pin für Pumpen-Container-ID {gpio_pin} nicht gefunden!")

def cleanPumps(time):
    all_pumps = Pump.Database().selectAllFromDatabase()
    for pump in all_pumps:
        if pump.pin is not None:
            print(f"GPIO {pump.pin}: cleaning")
            GPIO.setup(pump.pin, GPIO.OUT)
            GPIO.output(pump.pin, GPIO.LOW)
        else:
            logging.error(f"GPIO Pin für Pumpen-Container-ID {pump.container_id} nicht gefunden!")

    time.sleep(time)

    for pump in all_pumps:
        if pump.pin is not None:
            GPIO.setup(pump.pin, GPIO.OUT)
            GPIO.output(pump.pin, GPIO.HIGH)
        else:
            logging.error(f"GPIO Pin für Pumpen-Container-ID {pump.container_id} nicht gefunden!")
    print(f"fertig")

def start_pumpfor(gpio_pin,times):
    start_pump(gpio_pin)
    time.sleep(times)
    stop_pump(gpio_pin)


if __name__ == "__main__":
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    cleanPumps(10)
    GPIO.cleanup()