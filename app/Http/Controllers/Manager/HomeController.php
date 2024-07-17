<?php

namespace App\Http\Controllers\Manager;

use App\Models\Division;

class HomeController extends Controller
{
    /**
     * Show the manager home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.home.index');
    }

    public function more()
    {
        return view('manager.more.index');
    }

    public function moreWithDivision(\Illuminate\Http\Request $request, Division $division)
    {
        $user = $request->user();
        if ($user->consumer->ownTeam($division) > 1) {
            $ownTeam = $user->consumer->ownFirstApprovedTeamDetails($division);
        } else {
            $ownTeam = $user->consumer->ownTeamDetails($division);
        }

        return view('manager.more.index', compact('division', 'ownTeam'));
    }
}
