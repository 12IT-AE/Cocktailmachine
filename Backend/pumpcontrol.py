import time, logging

from models import Pump
try: 
    import RPi.GPIO as GPIO
except:
    import Mock.GPIO as GPIO
 

def start_pump(gpio_pin):
    print(f"Start Pump: {gpio_pin}")
    if gpio_pin is not None:
        GPIO.setmode(GPIO.BCM)
        logging.info(f"GPIO {gpio_pin}: starting")
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, GPIO.LOW)
    else:
        logging.error(f"GPIO {gpio_pin} nicht gefunden!")

def stop_pump(gpio_pin):
    print(f"Stop Pump: {gpio_pin}")
    if gpio_pin is not None:
        GPIO.setmode(GPIO.BCM)
        logging.info(f"GPIO {gpio_pin}: stopping!")
        GPIO.setup(gpio_pin, GPIO.OUT)
        GPIO.output(gpio_pin, GPIO.HIGH)
    else:
        logging.error(f"GPIO {gpio_pin} nicht gefunden!")

def cleanPumps(sec):
    all_pumps = Pump.Database().selectAllFromDatabase()
    for pump in all_pumps:
        if pump.pin is not None:
            print(f"GPIO {pump.pin}: cleaning")
            GPIO.setup(pump.pin, GPIO.OUT)
            GPIO.output(pump.pin, GPIO.LOW)
        else:
            logging.error(f"GPIO {pump.pin} nicht gefunden!")

    time.sleep(sec)

    for pump in all_pumps:
        if pump.pin is not None:
            GPIO.setup(pump.pin, GPIO.OUT)
            GPIO.output(pump.pin, GPIO.HIGH)
        else:
            logging.error(f"GPIO {pump.pin} nicht gefunden!")
    print(f"fertig")

def start_pumpfor(gpio_pin, sec):
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