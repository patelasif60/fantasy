<?php

namespace App\Http\Middleware;

use Closure;

class CheckPaymentForAuction
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
        $params = $request->route()->parameters('division');
        $division = $params['division'];
        if (! $division->isLeagueAccessible()) {
            if ($request->user()->consumer->ownLeagues($division)) {
                return redirect(route('manage.division.auction.settings', ['divsion' => $division]));
            }

            return redirect(route('manage.auction.payment.index', ['division' => $division, 'type'=>'auction']));
        }

        return $next($request);
    }
}
