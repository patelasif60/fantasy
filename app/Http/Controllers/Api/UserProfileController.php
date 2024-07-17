<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ClubService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Services\ConsumerUserService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Account\UpdateRequest;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserProfile as UserProfileResource;

class UserProfileController extends Controller
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * @var ConsumerUserService
     */
    protected $consumerUserService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $service
     * @param ClubService $clubService
     */
    public function __construct(UserService $service, ClubService $clubService, ConsumerUserService $consumerUserService)
    {
        $this->service = $service;
        $this->clubService = $clubService;
        $this->consumerUserService = $consumerUserService;
    }

    /**
     * Show the application Account Settings update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfileDetails(Request $request)
    {
        $user = $request->user();
        $clubs = $this->clubService->getPremierClubNames();
        $countryCode = [['value' => '+44' ,'text' => '+44'],['value' => '+91', 'text' => '+91'] ];

        return response()->json([
            'user' => new UserProfileResource($user),
            'clubs' => $clubs,
            'size' => ['width' => 250, 'height' => 250],
            'countryCode' => $countryCode,
            'messages' => __('messages.permission'),
        ]);
    }

    /**
     * save the application Account settings.
     * @param UpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function saveAccount(UpdateRequest $request)
    {
        $user = $request->user();
        $consumer = $this->service->saveAccountSettings($request->all(), $user);

        if ($consumer) {

            if($request->has('oldpic') && !$request->get('oldpic')) {

                if ($request->has('avatar') && $request->get('avatar')) {
                    $avatar = $consumer->addMediaFromBase64($request->get('avatar'));
                    $avatar->toMediaCollection('avatar');
                } else {
                    $this->consumerUserService->avatarDestroy($consumer);
                }
            }

            $user->fresh();

            return response()->json(['status' => 'success', 'data' => new UserResource($user), 'message' => 'Your Account Information has been updated.'], JsonResponse::HTTP_OK);

        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function notification(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'push_registration_id' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->service->saveUserRegistrationId($user, $request->only('push_registration_id'));

        if($user) {
            
            return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.updated.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
