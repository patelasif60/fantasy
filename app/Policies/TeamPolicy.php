<?php

namespace App\Policies;

use App\Enums\Role\RoleEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Models\Team;
use App\Models\TransferRound;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Team $team)
    {
        if ($user->hasRole(RoleEnum::SUPERADMIN)) {
            return true;
        }

        if ($user->consumer->id === $team->manager_id
            || $user->consumer->ownLeagues($team->teamDivision->first())
            || $user->consumer->coChairmanOwnLeagues($team->teamDivision->first())
        ) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Team $team)
    {
        $division = $team->teamDivision->first();
        if ($division->isPreAuctionState()) {
            if ($user->hasRole(RoleEnum::SUPERADMIN)) {
                return true;
            }

            if ($user->consumer->id === $team->manager_id
                || $user->consumer->ownLeagues($team->teamDivision->first())
                || $user->consumer->coChairmanOwnLeagues($team->teamDivision->first())
            ) {
                return (! $team->isPaid()) ? true : false;
            }

            return false;
        }

        return false;
    }

    public function ownTeam(User $user, Team $team)
    {
        return $team->manager_id === $user->consumer->id;
    }

    public function ownTeamWithActiveRound(User $user, Team $team, TransferRound $round = null)
    {
        return $this->ownTeam($user, $team) && ($round && $round->is_process == TransferRoundProcessEnum::UNPROCESSED && Carbon::parse($round->start)->lte(now()));
    }
}
