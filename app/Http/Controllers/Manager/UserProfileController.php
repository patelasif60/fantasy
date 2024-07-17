<?php

namespace App\Http\Controllers\Manager;

use App\Enums\UserStatusEnum;
use App\Http\Requests\Account\UpdateRequest;
use App\Http\Requests\IncompleteProfile\StoreRequest;
use App\Models\User;
use App\Services\ClubService;
use App\Services\ConsumerUserService;
use App\Services\UserService;
use Illuminate\Http\Request;
use JavaScript;

class UserProfileController extends Controller
{
    /**
     * @var UserService
     */
    protected $service;

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
     * Show the application incomplete profile update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function completeProfile(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        $status = UserStatusEnum::toSelectArray();
        $dob = explode('-', $user->consumer->dob);

        return view('manager.incompleteprofile.edit', compact('user', 'status', 'dob'));
    }

    /**
     * save the application incomplete profile update details.
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function saveCompleteProfile(StoreRequest $request)
    {
        $user = $this->service->incomplete_update(
            $request->user(),
            $request->all()
        );

        if ($user) {
            flash('Profile updated successfully')->success();
        } else {
            flash('Profile could not be updated. Please try again.')->error();
        }

        $intendedUrl = $request->session()->get('url.intended');
        if (! is_null($intendedUrl)) {
            return redirect()->intended($intendedUrl);
        }

        return redirect()->route('manage.division.package.selection');
    }

    /**
     * Show the application Account Settings update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAccount(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        $clubs = $this->clubService->getPremierClubNames();
        $avatarObject = $user->consumer->getMedia('avatar')->last();
        $division = auth()->user()->consumer->getDefaultDivison();

        if (! $division) {
            $ownDivisionTeams = auth()->user()->consumer->ownDivisionTeams();
            if ($ownDivisionTeams) {
                $division = $ownDivisionTeams->first();
            }
        }

        $avatar = '';
        if ($avatarObject) {
            $avatar = [
                'name' => $avatarObject->file_name,
                'type' => $avatarObject->mime_type,
                'size' => $avatarObject->size,
                'file' => $avatarObject->getUrl('thumb'),
                'data' => [
                    'url' => $avatarObject->getUrl('thumb'),
                    'id' => $avatarObject->id,
                ],
            ];
            $avatar = json_encode($avatar);
        }

        $status = UserStatusEnum::toSelectArray();
        JavaScript::put([
            'user' => $user->id,
        ]);

        return view('manager.more.user_account', compact('user', 'clubs', 'avatar', 'division'));
    }

    /**
     * save the application Account settings.
     * @param UpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function saveAccount(UpdateRequest $request)
    {
        $consumer = $this->service->saveAccountSettings($request->all(), $request->user());
        
        if ($consumer) {
            if ($request->hasFile('avatar')) {
                $avatar = $consumer->addMediaFromRequest('avatar');
                if ($crop = $request->imageshouldBeCropped('avatar')) {
                    $avatar->withManipulations([
                        'thumb' => [
                            'manualCrop' => $request->getCropParameters($crop),
                        ],
                    ]);
                }
                $avatar->toMediaCollection('avatar');
            } else {
                $returnVal = $request->imageShouldBeDeleted('avatar');
                if ($returnVal) {
                    $this->consumerUserService->avatarDestroy($consumer);
                }
            }
            flash(__('messages.data.account.success'))->success();
        } else {
            flash(__('messages.data.account.error'))->success();
        }

        return redirect(route('manage.account.settings'));
    }

    public function validateEmail(Request $request, $user = null)
    {
        $query = User::where('email', $request->get('email'));
        if ($user) {
            $query = $query->where('id', '!=', $user);
        }
        if ($query->count() === 0) {
            return 'true';
        }

        return 'false';
    }

    public function validateUserName(Request $request, $user = null)
    {
        $query = User::where('username', $request->get('username'));
        if ($user) {
            $query = $query->where('id', '!=', $user);
        }
        if ($query->count() === 0) {
            return 'true';
        }

        return 'false';
    }
}
