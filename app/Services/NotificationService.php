<?php

namespace App\Services;

use App\Repositories\NotificationRepository;
use Fcm;

class NotificationService
{
    /**
     * The notification repository instance.
     *
     * @var NotificationRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param ChatRepository $repository
     */
    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserPushRegistrationIds($managers)
    {
        $consumer = $this->repository->getUserPushRegistrationIds($managers);
        $pushRegistrationIds = $consumer->pluck('user.push_registration_id')->filter()->values()->all();

        return $pushRegistrationIds;
    }

    public function notification($division, $divisionManagers, $user, $chat)
    {
        $pushRegistrationIds = $this->getUserPushRegistrationIds($divisionManagers);

        if ($pushRegistrationIds) {

            info('Push Notifications :', ['status' => 'In']);

            $status = fcm()
                ->to($pushRegistrationIds) // $recipients must an array
                ->data([
                    'message' => $chat->message,
                    'leagueName' => $division->name,
                    'leagueID' => $division->id,
                    'senderName' => $user->first_name.' '.$user->last_name,
                    'senderID' => $user->consumer->id,
                    'time' => $chat->created_at,
                ])
                    ->notification([
                        'title' => $division->name.'-'.$user->first_name.' '.$user->last_name,
                        'body' => $chat->message,
                    ])
                    ->send();

            info('Push notification registration id : ', ['ids'=>json_encode($pushRegistrationIds)]);

            info('Push Notifications :', ['response' => json_decode(json_encode($status), true)]);

            return $status;
        }

        return false;
    }
}
