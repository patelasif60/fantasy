<?php

namespace App\Models;

use App\Enums\Role\RoleEnum;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    /**
     * The name of the role that should be displayed to the end-user.
     *
     * @return string
     */
    public function getDisplaynameAttribute()
    {
        switch ($this->name) {
            case RoleEnum::SUPERADMIN:
                return RoleEnum::getDescription(RoleEnum::SUPERADMIN);
            case RoleEnum::STAFF:
                return RoleEnum::getDescription(RoleEnum::STAFF);
            default:
                return RoleEnum::getDescription(RoleEnum::USER);
        }
    }
}
