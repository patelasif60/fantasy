<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, Division $division = null)
    {
        return view('manager.stat.index', compact('division'));
    }
}
