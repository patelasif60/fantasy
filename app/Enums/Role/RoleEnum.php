<?php

namespace App\Enums\Role;

use App\Enums\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class RoleEnum extends Enum implements LocalizedEnum
{
    const SUPERADMIN = 'superadmin';
    const STAFF = 'staff';
    const USER = 'user';
}
