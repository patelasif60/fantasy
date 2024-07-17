<?php

namespace App\Policies;

use App\Models\PastWinnerHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PastWinnerHistoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user, PastWinnerHistory $history)
    {
    }

    public function update(User $user, PastWinnerHistory $history)
    {
    }
}
