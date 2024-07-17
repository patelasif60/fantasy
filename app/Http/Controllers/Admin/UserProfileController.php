<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Profile\UpdateRequest;
use App\Services\UserService;

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
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the application profile update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(\Illuminate\Http\Request $request)
    {
        $user = $request->user();

        return view('admin.profile.create', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $user = $this->service->update(
            $request->user(),
            $request->all()
        );

        if ($user) {
            flash('User profile updated successfully')->success();
        } else {
            flash('User profile could not be updated. Please try again.')->error();
        }

        return redirect()->route('admin.users.profile');
    }
}
