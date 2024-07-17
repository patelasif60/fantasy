<?php

namespace App\Repositories;

use App\Models\Consumer;

class NotificationRepository
{
    public function getUserPushRegistrationIds($managers)
    {
        return Consumer::with('user')->find($managers->toArray());
    }
}
