<?php

namespace App\Enums\Division;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class StatusEnum extends Enum implements LocalizedEnum
{
    const ALLPAID = 'allPaid';
    const NOTPAID = 'notPaid';
}
