<?php

namespace App\Http\Middleware;

use Closure;

class CheckPaymentForLeague
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName();

        $params = $request->route()->parameters('division');
        if (isset($params['division'])) {
            $division = $params['division'];
        } else {
            //sometimes we get team details & not the division details from URL
            if (isset($params['team'])) {
                $team = $params['team'];
                $division = $team->teamDivision->first();
            } else {
                $divisions = $request->user()->consumer->ownDivisionWithRegisterTeam();
                $division = $divisions->first();
            }
        }

        if (! $division->isLeagueAccessible()) {
            $params = $request->route()->parameters('team');

            if (isset($params['team'])) {
                return redirect(route('manage.teams.index', ['division' => $division]));
            } else {
                return redirect(route('manage.division.payment.index', ['division' => $division, 'type'=>'league']));
            }
        }

        return $next($request);
    }
}
