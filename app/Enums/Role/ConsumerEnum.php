<?php

namespace App\Enums\Role;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class ConsumerEnum extends Enum implements LocalizedEnum
{
    const USER = 'user';
}
