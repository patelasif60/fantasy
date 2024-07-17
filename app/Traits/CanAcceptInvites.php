<?php

namespace App\Traits;

trait CanAcceptInvites
{
    public function hasPendingInvitation()
    {
        return $this->whereHas('invite', function ($query) {
            $query->whereNull('invitation_accepted_at');
        })->count() > 0;
    }

    public function hasAcceptedInvitation()
    {
        return $this->whereHas('invite', function ($query) {
            $query->whereNotNull('invitation_accepted_at');
        })->count() > 0;
    }
}
