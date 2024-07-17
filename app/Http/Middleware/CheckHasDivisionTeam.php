<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Http\Request;

class CheckHasDivisionTeam
{
    const COOKIE_EXPIRY = '7776000';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->route()->parameters('division');

        if (isset($params['division'])) {
            //if league is selected
            $division = $params['division'];
        } else {
            $divisions = $request->user()->consumer->ownDivisionWithRegisterTeam();

            if ($divisions) {
                $division = $divisions->first();
            }
        }

        if (! $division) {
            if (! is_null($request->user()->remember_url)) {
                return redirect($request->user()->remember_url);
            } else {
                return redirect('/home');
            }
        }

        if ($request->user()->consumer->ownTeam($division)) {
            if ($request->user()->consumer->ownTeam($division) > 1) {
                $team = $request->user()->consumer->ownFirstApprovedTeamDetails($division);
            } else {
                $team = $request->user()->consumer->ownTeamDetails($division);
            }
            if ($team->is_approved) {
                $this->setTeamRememberCookie($request, $division, $team);

                return $next($request);
            } else {
                if ($request->get('via') == 'social') {
                    $this->setTeamRememberCookie($request, $division, $team);

                    return $next($request);
                }
                if ($division->package->private_league == 'Yes') {
                    return redirect(route('manage.division.approval.msg', ['division' => $division, 'team' => $team]));
                }
            }
        } else {
            if ($request->user()->can('ownLeagues', $division)) {
                $this->setTeamRememberCookie($request, $division);

                return $next($request);
            } elseif ($request->user()->consumer->ownTeamInParentAssociatedLeague($division)) {
                $this->setTeamRememberCookie($request, $division);

                return $next($request);
            } else {
                return redirect(route('manage.division.create.team', ['division'=>$division, 'via=join']));
            }
        }

        $this->setTeamRememberCookie($request, $division);

        return $next($request);
    }

    /* * access previous visited team via cookies
    *   set cookies for the current accessed team
    */
    public function setTeamRememberCookie(Request $request, $division, $team = null)
    {
        $params = $request->route()->parameters('team');
        if (isset($params['team'])) {
            $team = $params['team'];

            $teamDetails['id'] = $team->id;
            $teamDetails['division_id'] = $division->id;
            $teamDetails['consumer_id'] = $request->user()->consumer->id;
            if (Cookie::get('last_viewed_team')) {
                Cookie::forget('last_viewed_team');
            }

            Cookie::queue('last_viewed_team', json_encode($teamDetails), self::COOKIE_EXPIRY);
        }
    }
}
