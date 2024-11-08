# Pumpenansteuerung
# try:
#     import RPi.GPIO as GPIO
# except:
import time, logging
import Mock.GPIO as GPIO

pumps = [4, 17, 27, 22, 23, 24, 13, 19]


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

    time.sleep(30)

    for pump in pumps:
        GPIO.setup(pump, GPIO.OUT)
        GPIO.output(pump, GPIO.HIGH)


if __name__ == "__main__":
    cleanPumps()
    GPIO.cleanup()