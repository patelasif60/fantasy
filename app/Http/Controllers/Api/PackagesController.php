<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller as BaseController;
use App\Models\Package;
use App\Services\PackageService;

class PackagesController extends BaseController
{
    /**
     * @var PackageService
     */
    protected $service;

    /**
     * PackagesController constructor.
     *
     * @param PackageService $service
     */
    public function __construct(PackageService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selection()
    {
        return response()->json([
            'data' => $this->service->list(),
        ]);
    }

    /**
     * Display all details of the specified package for division.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function description(Package $package)
    {
        return response()->json([
            'data' => $package,
        ]);
    }
}
