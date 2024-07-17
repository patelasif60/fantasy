<?php

namespace App\Enums\Role;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class AdminEnum extends Enum implements LocalizedEnum
{
    const SUPERADMIN = 'superadmin';
    const STAFF = 'staff';
}
