# Pumpenansteuerung
try:
    import RPi.GPIO as GPIO
except:
    import Mock.GPIO as GPIO

import time, logging

# pumps = [4, 17, 27, 22, 23, 24, 13, 19]
pumps = [7, 11, 13, 15, 16, 18, 35, 37]


def start_pump(index):
    print('start Pump:')
    print(index)
    GPIO.setmode(GPIO.BCM)
    logging.info("GPIO %s: starting", pumps)
    GPIO.setup(pumps[index], GPIO.OUT)
    GPIO.output(pumps[index], GPIO.LOW)


def stop_pump(index):
    print('stop Pump:')
    print(index)
    GPIO.setup(pumps[index], GPIO.OUT)
    GPIO.output(pumps[index], GPIO.HIGH)
    logging.info("GPIO %s: stopping!", pumps)


def cleanPumps():
    for pump in pumps:
        logging.info("GPIO %s: cleaning", pump)
        GPIO.setup(pump, GPIO.OUT)
        GPIO.output(pump, GPIO.LOW)

    time.sleep(1)

    for pump in pumps:
        GPIO.setup(pump, GPIO.OUT)
        GPIO.output(pump, GPIO.HIGH)


if __name__ == "__main__":
    try:
        GPIO.setmode(GPIO.BCM)
    except:
        pass
    cleanPumps()
    GPIO.cleanup()