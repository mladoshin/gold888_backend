<?php

namespace App\Enums;

enum ConsumptionTypeEnum :string
{
    case SALARY = 'salary';
    case RENT = 'rent';
    case INVESTORS = 'investors';
    case CREDIT = 'credit';
    case OTHER_CONSUMPTIONS = 'other_consumptions';
    case UNEXPECTED_CONSUMPTIONS = 'unexpected_consumptions';
}
