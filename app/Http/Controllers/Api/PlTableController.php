<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PlTableService;
use Illuminate\Http\JsonResponse;

class PlTableController extends Controller
{
    /**
     * @var PlTableService
     */
    protected $service;

    public function __construct(PlTableService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = $this->service->stats();

        return response()->json(['status' => 'success', 'data' => $clubs], JsonResponse::HTTP_OK);
    }
}
