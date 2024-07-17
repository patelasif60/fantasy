<?php

namespace App\Traits;

use App\Enums\Role\RoleEnum;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

trait RedirectToPath
{
    /**
     * Where to redirect consumer users after login.
     *
     * @var string
     */
    protected $usersRedirectTo = 'manage.division.teams.index';

    /**
     * Where to redirect admin and staff users after login.
     *
     * @var string
     */
    protected $adminsRedirectTo = 'admin.dashboard.index';

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        $user = $this->guard()->user();

        if ($user->hasRole(RoleEnum::USER)) {
            if (Session::has('url.intended')) {
                return Session::get('url.intended');
            }

            return $this->redirectToState($user);
        }

        return route($this->adminsRedirectTo);
    }

    protected function redirectPreviousTeam()
    {
        $lastViewedTeam = Cookie::get('last_viewed_team');

        if ($lastViewedTeam) {
            $teamArray = (array) json_decode($lastViewedTeam);
            $division = \App\Models\Division::find($teamArray['division_id']);
            $team = \App\Models\Team::find($teamArray['id']);

            if (request()->user()->consumer->id == $teamArray['consumer_id']) {
                return route('manage.team.lineup', ['division'=>$division, 'team' => $team]);
            }
        }

        return false;
    }

    protected function redirectToState($user)
    {
        $divisions = $user->consumer->ownDivisionWithRegisterTeam();

        if ($divisions->count() > 0) {
            $defaultDivision = '';
            foreach ($divisions as $key => $division) {
                if ($user->consumer->ownTeamDetails($division)) {
                    $defaultDivision = $division;
                }
            }
            if (! $defaultDivision) {
                $division = $divisions->first();
            } else {
                $division = $defaultDivision;
            }
        } else {
            return route($this->usersRedirectTo);
        }
        if ($division) {
            $team = $user->consumer->ownTeamDetails($division);
            if ($team) {
                if (! $division->isLeagueAccessible()) {
                    return route('manage.division.payment.index', ['division' => $division, 'type'=>'league']);
                } elseif ($division->isInAuctionState()) {
                    return route('manage.auction.index', ['division' => $division]);
                } elseif ($division->isPreAuctionState()) {
                    return route('manage.auction.payment.index', ['division' => $division, 'type'=>'auction']);
                } else {
                    if ($this->redirectPreviousTeam()) {
                        return $this->redirectPreviousTeam();
                    } else {
                        return route('manage.team.lineup', ['division' => $division, 'team' => $team]);
                    }
                }
            }
        }

        return route($this->usersRedirectTo);
    }
}
