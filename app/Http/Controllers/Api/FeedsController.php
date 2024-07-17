<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller as BaseController;
use App\Models\Division;
use App\Services\FeedCountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeedsController extends BaseController
{
    /**
     * @var FeedCountService
     */
    protected $feedCountService;

    public function __construct(FeedCountService $feedCountService)
    {
        $this->feedCountService = $feedCountService;
    }

    public function read(Request $request, Division $division)
    {
        $this->feedCountService->updateUnreadFeeds($request->user('api')->consumer);

        return response()->json(['status' => true, 'message' => 'success'], JsonResponse::HTTP_OK);
    }

    public function getUrl(Request $request, Division $division)
    {
        $path = rtrim(config('fantasy.wordpress_url'), '/') . '/';
        
        return response()->json(['status' => true, 'url' => $path ], JsonResponse::HTTP_OK);
    }
}
