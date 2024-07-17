<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Models\User;
use App\Traits\RedirectToPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;

class SocialLoginController extends LoginController
{
    use RedirectToPath;

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param $provider Social auth provider
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that redirect them to the authenticated users homepage.
     * @param $request Request object
     * @param $provider Social auth provider
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();

            if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                $authUser = $this->findOrCreateUser($request, $user, $provider);
                //Automatically Log in the user
                Auth::login($authUser, true);
                $this->authenticated($request, $authUser);

                return redirect($this->redirectPath());
            } else {
                flash(__('We could not retrieve your email address from '.ucfirst($provider).'. To continue, please sign up using your email address.'))->error();

                return redirect()->route('register');
            }
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser(\Illuminate\Http\Request $request, $user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            $authUser->update([
                'provider'      => $provider,
                'provider_id'   => $user->id,
            ]);

            return $authUser;
        }

        $data = string_split_firstname_lastname($user->name);

        return User::firstOrCreate([
            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'],
            'email'           => $user->email,
            'provider'        => $provider,
            'provider_id'     => $user->id,
            'status'          => UserStatusEnum::__default,
            'remember_url'    => (true == $request->session()->has('url.intended')) ? $request->session()->get('url.intended') : null,
        ])->assignDefaultRole();
    }
}
