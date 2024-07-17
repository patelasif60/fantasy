<?php

namespace App\Http\Controllers\Api;

use App\Events\LeagueMessageReceived;
use App\Http\Resources\ChatCollection;
use App\Models\Chat;
use App\Models\Division;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FeedCountService;
use App\Http\Controllers\Api\Controller as BaseController;

class ChatsController extends BaseController
{
    /**
     * @var ChatService
     */
    protected $service;

    /**
     * @var FeedCountService
     */
    protected $feedCountService;

    public function __construct(ChatService $service, FeedCountService $feedCountService)
    {
        $this->service = $service;
        $this->feedCountService = $feedCountService;
    }

    public function getMessages(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division) && ! $request->user()->can('ownTeam', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $consumer = $request->user()->consumer->id;
        $noOfRecords = (int) $request->get('noOfRecords',100);

        $messages = $this->service->getMessages($division, $consumer, $noOfRecords);

        return  new ChatCollection($messages);
    }

    public function getUnreadMessageCount(Request $request, Division $division)
    {
        if (! $request->user()->can('ownLeagues', $division) && ! $request->user()->can('ownTeam', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $consumer = $request->user('api')->consumer;

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
        if (! $request->user()->can('ownLeagues', $division) && ! $request->user()->can('ownTeam', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $consumer = $request->user()->consumer->id;

        $validator = Validator::make($request->all(), [
            'current_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->all();

        $this->service->updateUnreadMessage($division, $consumer, $data);

        return response()->json(['status' => 'success', 'message' => __('messages.data.updated.success')], JsonResponse::HTTP_OK);
    }

    public function create(Division $division, Request $request)
    {
        if (! $request->user()->can('ownLeagues', $division) && ! $request->user()->can('ownTeam', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $user = $request->user();
        $consumer = $user->consumer->id;
        $data = $request->all();
        $data['consumer_id'] = $consumer;

        $validator = Validator::make($request->all(), [
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            
            return response()->json(['status' => 'error', 'message' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $chat = $this->service->create($division, $user, $data);
        $chat->load('consumer.user');

        event(new LeagueMessageReceived($division, $chat));

        return response()->json(['status' => 'success', 'message' => __('messages.data.saved.success')], JsonResponse::HTTP_OK);
    }

    public function delete(Request $request, Division $division, Chat $chat)
    {
        if (! $request->user()->can('ownLeagues', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $chat = $this->service->delete($division, $chat);

        if ($chat) {
            return response()->json(['status' => 'success', 'message' => __('messages.data.deleted.success')], JsonResponse::HTTP_OK);
        }

        return response()->json(['status' => 'error', 'message' => __('messages.data.deleted.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
