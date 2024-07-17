<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AuctionRoundPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
    }
}
