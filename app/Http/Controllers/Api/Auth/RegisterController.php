<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Api\Controller as BaseController;
use App\Mail\Auth\RegisterEmail;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;

class RegisterController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $data = $request->all();

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
}
