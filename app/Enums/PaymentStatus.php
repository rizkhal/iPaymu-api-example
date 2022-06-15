<?php

namespace App\Enums;

use App\Enums\Traits\InvokableCases;

enum PaymentStatus: int
{
    use InvokableCases;

    case CREATED = -1;
    case PENDING = 0;
    case COMPLETE = 1;
    case FAILED = 2;
}
