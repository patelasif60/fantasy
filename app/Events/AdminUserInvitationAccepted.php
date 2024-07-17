<?php

namespace App\Events;

use App\Models\AdminInviteUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminUserInvitationAccepted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The invite that got accepted.
     *
     * @var AdminInviteUser
     */
    public $invite;

    /**
     * Create a new event instance.
     *
     * @param AdminInviteUser $invite
     */
    public function __construct(AdminInviteUser $invite)
    {
        $this->invite = $invite;
    }
}
