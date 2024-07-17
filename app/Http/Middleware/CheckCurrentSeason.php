<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Season;

class CheckCurrentSeason
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
        if ($division->getSeason() !== Season::getLatestSeason()) {
            info('Redirect user '.$division->id);
            return redirect(route('frontend'));
        }

        return $next($request);
    }
}
