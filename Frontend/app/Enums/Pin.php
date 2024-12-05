<?php

namespace App\Enums;
// pumps = [7, 11, 13, 15, 16, 18, 35, 37]
// [4, 17, 27, 22, 23, 24, 13, 19]

enum Pin: int
{
    case PIN_4 = 4;
    case PIN_17 = 17;
    case PIN_18 = 18;
    case PIN_27 = 27;
    case PIN_22 = 22;
    case PIN_23 = 23;
    case PIN_24 = 24;
    case PIN_5 = 5;
    case PIN_6 = 6;
    case PIN_12 = 12;
    case PIN_13 = 13;
    case PIN_19 = 19;
    case PIN_16 = 16;
    case PIN_26 = 26;
    case PIN_20 = 20;
    case PIN_21 = 21;
    case PIN_25 = 25;

    public static function getActives(){
        return [
            self::PIN_4,
            self::PIN_17,
            self::PIN_27,
            self::PIN_22,
            self::PIN_23,
            self::PIN_24,
            self::PIN_13,
            self::PIN_19
        ];
    }
}
