<?php

namespace App\Http\Controllers\Api\Auth;

use JWTAuth;
use Socialite;
use Google_Client;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\Role\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\User as UserResource;
use Laravel\Socialite\Two\User as GoogleUser;
use App\Http\Resources\Division as DivisionResource;
use App\Http\Controllers\Api\Controller as BaseController;

class SocialLoginController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'provider' => 'required|in:facebook,google,apple',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = $request->get('token');
        $provider = $request->get('provider');

        try {
            switch ($provider) {
                case 'google':
                        $client = new Google_Client(['client_id' => config('services.google.mobile_client_id')]);
                        $payload = $client->verifyIdToken($token);
                        if ($payload) {
                            $user = $this->googleUserData($payload);
                        } else {
                            throw ValidationException::withMessages([
                                'token' => [trans('auth.failed')],
                            ]);
                        }
                    break;
                    case "apple":
                        $user = new \stdClass();
                        $user->id = $token;
                        $user->email = $request->get('email','');
                        break;
                default:
                    $user = Socialite::driver($provider)->userFromToken($token);
            }
        } catch (Exception $e) {

            throw ValidationException::withMessages([ 'token' => [trans('auth.invalid_token')], 'sent_token'=> $token]);
        }

        if ($user->email == "" || $user->email == NULL) {

            throw ValidationException::withMessages([
                'email' => [ "We could not retrieve your email address from ".ucfirst($provider).". To continue, please sign up via your email address." ]
            ]);
        }

        $authUser = User::where(['provider_id' => $user->id, 'status' => 'Active' ])->first();

        if (!$authUser) {

            if($this->isEmailInUse($user->email)) {

                throw ValidationException::withMessages([ 'email' => ["The email has already been taken."] ]);
            }
           
           if($provider == 'apple') {
                $data = [];
                $data['first_name'] = $request->get('first_name');
                $data['last_name'] = $request->get('last_name');
            } else {
                $data = string_split_firstname_lastname($user->name);
            }

            $authUser = User::firstOrCreate([
                'first_name'      => $data['first_name'],
                'last_name'       => $data['last_name'],
                'email'           => $user->email,
                'provider'        => $provider,
                'provider_id'     => $user->id,
                'status'          => UserStatusEnum::__default,
            ])->assignDefaultRole();

            $userService = app(UserService::class);
            $userService->createConsumer($authUser, []);
        }

        if($authUser) {
            $token = JWTAuth::fromUser($authUser);
            if ($token) {
                return $this->sendLoginResponse($authUser, $token);
            }
        }

        throw ValidationException::withMessages(['token' => [trans('auth.failed')]]);
    }

    public function isEmailInUse($email)
    {
        $count = User::where('email',$email)->count();

        return $count > 0;
    }

    protected function googleUserData(array $user)
    {
        return (new GoogleUser)->setRaw($user)->map([
            'id' => $user['sub'],
            'nickname' => isset($user['name']) ? $user['name'] : '',
            'name' => isset($user['name']) ? $user['name'] : '',
            'email' => $user['email'],
            'avatar' => isset($user['picture']) ? $user['picture'] : '',
            'avatar_original' => isset($user['picture']) ? $user['picture'] : '',
        ]);
    }

    protected function sendLoginResponse($user, $token)
    {
        if ($user->hasRole(RoleEnum::USER)) {

            $leagues = $user->consumer->ownDivisionWithRegisterTeam(['divisionTeams.manager']);

            session(['socialLoginUser' => $user]);

            $user->update([
                'last_login_at' => now(),
                'signin_token' => md5($user->email.rand(1,9999)),
                'auto_signin' => true,
            ]);

            return response()->json([
                'user' => new UserResource($user),
                'token' => $token,
                'leagues' => DivisionResource::collection($leagues),
                'feature_disabled' => config('fantasy_app.feature_disabled'),
            ]);
        }

        throw ValidationException::withMessages([
            'token' => [trans('auth.failed')],
        ]);
    }
}
