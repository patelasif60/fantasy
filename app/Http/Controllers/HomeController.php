<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function iosJson()
    {
        $data = file_get_contents(asset('ios/apple-app-site-association'));

        return response($data, 200)
                  ->header('Content-Type', 'application/json');
    }
    public function autologin(Request $request)
    {
    	$user = User::where('signin_token',$request['token'])->get()->first();
    	if($user)
    	{
    		Auth::loginUsingId($user->id);
            if($request['section']=='joinleague')
            {
                return redirect()->route('manage.division.join.league.select');
            }
            if($request['section']=='createleague')
            {
                return redirect()->route('manage.division.create');
            }
    	}

    	return redirect()->route('landing');	
    }
}