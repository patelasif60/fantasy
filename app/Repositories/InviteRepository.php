<?php

namespace App\Repositories;

use App\Events\Manager\Divisions\LeagueInvitationSMSToManager;
use App\Events\Manager\Divisions\LeagueInvitationToManager;
use App\Models\Division;
use App\Models\InviteCode;
use Illuminate\Support\Facades\Auth;

class InviteRepository
{
    public function getInvitation($division_id, $user_id = 'NA')
    {
        if (strtoupper($user_id) == 'NA') {
            $user_id = Auth::id();
        }

        return InviteCode::where(
            [
                'user_id' => $user_id,
                'division_id' => $division_id,
            ]
        )
                                ->first();
    }

    public function invitation($division)
    {
        $user_id = $division->consumer->user->id;

        $invitation = InviteCode::firstOrCreate(
            [
                'division_id' => $division->id,
                'user_id' => $user_id,
            ],
            [
                'division_id' => $division->id,
                'user_id' => $user_id,
                'code' => strtoupper(substr(md5($division->id), 0, 6)),
            ]
        );

        return $invitation;
    }

    public function sendInvitations($data, $division)
    {
        info('Mail Send.....');
        info($data);
        $division_id = $division->id;

        if (! empty($data['email']) && count($data['email']) > 0) {
            info('Start Send email.....');
            info($data['email']);
            $invitation = $this->invitation($division);

            $invitationData['user'] = Auth::user();
            $invitationData['division'] = $division;
            $invitationData['emails'] = $data['email'];
            $invitationData['invitationUrl'] = route('manager.division.join.a.league', ['code' => $invitation->code]);

            // Fire off the event
            event(new LeagueInvitationToManager($invitationData));

            info('Send email doneeeee.');
        }

        $invitation = [];
        if (! empty($data['phone']) && count($data['phone']) > 0) {
            $invitation = $this->invitation($division);

            $user = Auth::user();
            $invitationUrl = route('manager.division.join.a.league', ['code' => $invitation->code]);
            $message = 'You have been invited by '.$user->first_name.' '.$user->last_name.' to join '.$division->name."\n".$invitationUrl."\nThanks,\n".
                config('app.name');

            $invitationData['phones'] = $data['phone'];
            $invitationData['message'] = $message;

            // Fire off the event
            event(new LeagueInvitationSMSToManager($invitationData));
        }

        return 'true';
    }

    public function getDivisionByInviteCode($code)
    {
        return Division::with('inviteCode', 'consumer', 'consumer.user')
                    ->whereHas('inviteCode', function ($query) use ($code) {
                        $query->where('code', $code);
                    })->first();
    }
}
