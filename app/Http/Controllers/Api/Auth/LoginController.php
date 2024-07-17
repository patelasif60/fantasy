<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\Role\RoleEnum;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Division as DivisionResource;
use App\Http\Controllers\Api\Controller as BaseController;

class LoginController extends BaseController
{
    public function login(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $this->credentials($request);

        $token = auth('api')->attempt($credentials);
        
        if ($token) {
            return $this->sendLoginResponse($token, $request);
        }

        // attempt login with master password
        $token = auth('api')->claims(['is_master_login' => true])
            ->attemptWithMasterCredentials($credentials);

        if ($token) {
            return $this->sendLoginResponse($token, $request);
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        return [
            $field => $request->get('email'),
            'password' => $request->get('password'),
            'status' => UserStatusEnum::ACTIVE,
            'provider' => 'email',
        ];
    }

    protected function sendLoginResponse($token, $request)
    {
        $user = auth('api')->user();
        
        if ($user->hasRole(RoleEnum::USER)) {


            $accessToken = md5($request->get('email').rand(1,9999));
            $leagues = $user->consumer->ownDivisionWithRegisterTeam(['divisionTeams.manager']);

            $user->update([
                'last_login_at' => now(),
                'signin_token' =>$accessToken,
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
            'email' => [trans('auth.failed')],
        ]);
    }
    public function logout(Request $request)
    {
        User::where('signin_token','=',$request['token'])->update(array('signin_token' =>null));
        return response()->json([
                'status' => true]);
    }
}
