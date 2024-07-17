<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasicController extends BaseController
{
    public function index(Request $request)
    {
        $data = config('fantasy_app')[$request->get('type')];
        
        return response()->json(['status' => true, 'data' => $data ], JsonResponse::HTTP_OK);
    }
}
