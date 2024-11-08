import time, sys

EMULATE_HX711 = False

if not EMULATE_HX711:
    import RPi.GPIO as GPIO
    from hx711 import HX711
else:
    from emulated_hx711 import HX711


class Scale:
    def __init__(self):
        self.hx = HX711(5, 6)
        self.hx.set_reading_format("MSB", "MSB")
        self.hx.set_reference_unit(107)
        self.hx.reset()
        self.hx.tare()
        print("Tare done! Add weight now...")

    def weight(self):
        return int(self.hx.get_weight())

    def tare(self):
        print('Before Tare:')
        print(self.weight())
        self.hx.reset()
        self.hx.tare()
        print('After Tare:')
        print(self.weight())
        print("Tare done! Add weight now...")

    def cleanAndExit(self):
        print("Cleaning...")

        if not EMULATE_HX711:
            GPIO.cleanup()

        print("Bye!")
        sys.exit()
