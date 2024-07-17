<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Division;

class InviteManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Division $division)
    {
        $this->authorize('update', $division);

        $code = '';
        if ($division->inviteCode) {
            $code = $division->inviteCode->code;
        }

        return view('manager.divisions.invite_managers', compact('code', 'division'));
    }
}
