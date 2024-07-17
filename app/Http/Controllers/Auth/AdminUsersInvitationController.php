<?php

namespace App\Http\Controllers\Auth;

use App\Events\AdminUserInvitationAccepted;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserInvitationAcceptRequest;
use App\Models\AdminInviteUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsersInvitationController extends Controller
{
    /**
     * Display the page to accept the invitation.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $invite = AdminInviteUser::with('user')
            ->where('token', $token)
            ->whereNull('invite_accepted_at')
            ->firstOrFail();

        return view('auth.admins.invitation.show', compact('invite', 'token'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminUserInvitationAcceptRequest $request
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accept(AdminUserInvitationAcceptRequest $request, $token)
    {
        // Verify token with invitation
        $invite = AdminInviteUser::with('user')
            ->where('token', $token)
            ->whereNull('invite_accepted_at')
            ->firstOrFail();

        $invite->update([
            'invite_accepted_at' => now(),
        ]);

        // Set password
        $invite->user()->update([
            'password' => Hash::make($request->get('password')),
        ]);

        // Login
        $this->guard()->login($invite->user);

        // Fire event and send email
        event(new AdminUserInvitationAccepted($invite));

        return redirect()->route('admin.dashboard.index');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
