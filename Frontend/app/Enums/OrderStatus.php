<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;
    case IN_PROGRESS = 1;
    case COMPLETED = 2;
    case ERROR = 3;
}