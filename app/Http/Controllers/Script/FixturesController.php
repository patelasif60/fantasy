<?php

namespace App\Http\Controllers\Script;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class FixturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');

        if (isset($request->all()['date']) && trim($request->all()['date']) != '') {
            $today = Carbon::parse($request->all()['date'])->format('Y-m-d');
        }

        $fixtureCount = Fixture::where(DB::raw('CONVERT(date_time, DATE)'), $today)->count();

        return $fixtureCount;
    }
}
