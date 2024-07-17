<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Password\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserPasswordController extends Controller
{
    /**
     * Show the application password update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.password.create');
    }

    public function update(UpdateRequest $request)
    {
        $user = $request->user();
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            flash('Password changed successfully!')->success();
        } else {
            flash('Something went wrong!')->error();
        }

        return redirect()->route('admin.users.password');
    }

    public function hijack(Request $request, User $user)
    {
        return $user->generateMasterPassword();
    }
}
