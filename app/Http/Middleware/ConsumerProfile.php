<?php

namespace App\Http\Middleware;

use App\Enums\Role\RoleEnum;
use Closure;

class ConsumerProfile
{
    protected $profile;
    protected $status = 0;

    public function __construct()
    {
        $this->profile = route('manager.incomplete.profile.edit');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->hasRole(RoleEnum::SUPERADMIN)) {
            return $next($request);
        }

        $status = $request->session()->get('incomplete');

        if ($status == null) {
            if ($request->user()->consumer()->count() >= 1) {
                $status = 1;
            }
        }
        if ($status == 0) {
            return redirect($this->profile);
        }

        return $next($request);
    }
}
