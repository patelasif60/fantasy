<?php

namespace App\Policies;

use App\Enums\CustomCupStatusEnum;
use App\Models\CustomCup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomCupPolicy
{
    use HandlesAuthorization;

    public function update(User $user, CustomCup $customCup)
    {
        return $user->can('allowCustomCupChairman', $customCup->division) && ($customCup->status === CustomCupStatusEnum::PENDING);
    }

    public function delete(User $user, CustomCup $customCup)
    {
        return $user->can('allowCustomCupChairman', $customCup->division);
    }

    public function detail(User $user, CustomCup $customCup)
    {
        return $user->can('allowCustomCupChairman', $customCup->division);
    }
}
