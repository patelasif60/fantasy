<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Services\ChatService;
use App\Services\FeedCountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use JavaScript;

class FeedsController extends Controller
{
    /**
     * @var ChatService
     */
    protected $chatService;

    /**
     * @var FeedCountService
     */
    protected $feedCountService;

    public function __construct(ChatService $chatService, FeedCountService $feedCountService)
    {
        $this->chatService = $chatService;
        $this->feedCountService = $feedCountService;
    }

    public function index(Request $request, Division $division)
    {
        $consumer = $request->user()->consumer;
        $team = $consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManagerOrParentleague', [$division, $team]);

        $consumer = $consumer->id;
        $messages = $this->chatService->getMessages($division, $consumer);

        $nextPageUrl = $messages->toArray()['next_page_url'];
        $messages = $messages->reverse();
        $messages = $messages->groupBy(function ($item) {
            return Carbon::createFromFormat(config('fantasy.db.datetime.format'), $item->created_at)->format(config('fantasy.db.date.format'));
        });

        if ($request->has('page')) {
            $data = view('manager.feed.partials.message', compact('division', 'messages', 'consumer', 'nextPageUrl'))->render();

            return response()->json(['success' => true, 'data'=> $data]);
        }

        $this->chatService->updateUnreadMessage($division, $consumer);

        JavaScript::put([
            'divisionID' => $division->id,
            'user' => $request->user()->load('consumer'),
            'wordpressUrl' => config('fantasy.wordpress_url'),
        ]);

        return view('manager.feed.index', compact('division', 'messages', 'consumer', 'nextPageUrl', 'team'));
    }

    public function postDetails(Division $division, $slug)
    {
        JavaScript::put([
            'wordpressUrl' => config('fantasy.wordpress_url'),
            'slug' => $slug,
        ]);

        return view('manager.feed.news_details', compact('division'));
    }

    public function read(Request $request, Division $division)
    {
        $this->feedCountService->updateUnreadFeeds($request->user()->consumer);

        return response()->json(['status' => true, 'message' => 'success'], JsonResponse::HTTP_OK);
    }
}
