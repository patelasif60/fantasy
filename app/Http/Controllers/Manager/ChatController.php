<?php

namespace App\Http\Controllers\Manager;

use App\Events\LeagueMessageReceived;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Division;
use App\Services\ChatService;
use App\Services\FeedCountService;
use App\Services\LeaguePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * @var ChatService
     */
    protected $service;
    /**
     * @var LeaguePaymentService
     */
    protected $leaguePaymentService;

    /**
     * @var FeedCountService
     */
    protected $feedCountService;

    public function __construct(ChatService $service, LeaguePaymentService $leaguePaymentService, FeedCountService $feedCountService)
    {
        $this->service = $service;
        $this->leaguePaymentService = $leaguePaymentService;
        $this->feedCountService = $feedCountService;
    }

    public function store(Division $division, Request $request)
    {
        $user = $request->user();
        $consumer = $user->consumer->id;
        $data = $request->all();
        $data['consumer_id'] = $consumer;

        if ($request->has('message')) {
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }

            $chat = $this->service->create($division, $user, $data);
            $chat->load('consumer.user');

            event(new LeagueMessageReceived($division, $chat));

            $data = ['messageClass' => 'message-sender', 'id' => $chat->id, 'division' => $division, 'first_name' => $chat->consumer->user->first_name, 'last_name' => $chat->consumer->user->last_name, 'message' => $chat->message, 'time' => $chat->created_at];

            $chatData = view('manager.feed.partials.chat', $data)->render();

            return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success'), 'chatData' => $chatData], JsonResponse::HTTP_OK);
        }
    }

    public function getUnreadMessageCount(Request $request, Division $division)
    {
        $consumer = $request->user()->consumer;

        if ($consumer) {
            $unreadChat = $this->service->getUnreadMessageCount($division, $consumer->id);

            $unreadFeed = $this->feedCountService->getUnreadCount($consumer);

            $unread = $unreadFeed + $unreadChat;

            return response()->json(['status' => true, 'unread' => $unread, 'feedUnread' => $unreadFeed, 'chatUnread' => $unreadChat], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function updateUnreadMessage(Request $request, Division $division)
    {
        $consumer = $request->user()->consumer->id;

        $this->service->updateUnreadMessage($division, $consumer);

        return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
    }

    public function delete(Request $request, Division $division, Chat $chat)
    {
        $this->authorize('ownLeagues', $division);

        $chat = $this->service->delete($division, $chat);

        if ($chat) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.deleted.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.deleted.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function newMessage(Request $request, Division $division)
    {
        $data = ['messageClass' => $request->get('messageClass'), 'id' => $request->get('id'), 'division' => $division, 'first_name' => $request->get('first_name'), 'last_name' => $request->get('last_name'), 'message' => $request->get('message'), 'time' => $request->get('created_at')];

        $chatData = view('manager.feed.partials.chat', $data)->render();

        return response()->json(['status' => 'success', 'chatData' => $chatData], JsonResponse::HTTP_OK);
    }
}
