<?php

namespace App\Http\Controllers\Auth;

use Aecor\MasterPassword\AuthenticatesUsersWithMasterPassword;
use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Traits\RedirectToPath;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use RedirectToPath {
        RedirectToPath::redirectPath insteadof AuthenticatesUsers;
    }

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, AuthenticatesUsersWithMasterPassword {
        AuthenticatesUsersWithMasterPassword::login insteadof AuthenticatesUsers;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
            'status' => UserStatusEnum::ACTIVE,
            'provider' => 'email',
        ];
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => now(),
        ]);
    }
}