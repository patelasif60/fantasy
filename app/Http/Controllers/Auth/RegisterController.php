<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Mail\Auth\RegisterEmail;
use App\Models\User;
use App\Services\UserService;
use App\Traits\RedirectToPath;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;

class RegisterController extends Controller
{
    public $userService;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, RedirectToPath {
        RedirectToPath::redirectPath insteadof RegistersUsers;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'username'      => $data['email'],
            'password'      => Hash::make($data['password']),
            'status'        => UserStatusEnum::__default,
            'provider'      => 'email',
            'remember_url'  => (true == \Session::has('url.intended')) ? \Session::get('url.intended') : null,
        ])->assignDefaultRole();

        $this->userService->createConsumer($user, $data);
        $data['name'] = ucfirst($data['first_name'] ? $data['first_name'] : $data['last_name']);
        $mail = Mail::to($data['email'])->send(new RegisterEmail($data));

        return $user;
    }

    public function redirect(\Illuminate\Http\Request $request, $next)
    {
        $route = route('manage.division.join.league.select');
        if ($next == 'create') {
            $route = route('manage.division.create');
        }
        $request->session()->put('url.intended', $route);

        return redirect(route('register'));
    }
}
