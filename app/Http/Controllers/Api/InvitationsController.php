<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Invitation\InviteCodeRequest;
use App\Http\Requests\InviteManager\SendInvitationRequest;
use App\Models\Division;
use App\Services\InviteService;

class InvitationsController extends Controller
{
    /**
     * @var InviteService
     */
    protected $service;

    /**
     * InviteManagersController constructor.
     *
     * @param InviteService $service
     */
    public function __construct(InviteService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInvitation(Division $division)
    {
        return response()->json([
            'data' => $division->inviteCode,
        ]);
    }

    public function getDivision(InviteCodeRequest $request)
    {
        $data = $this->service->getDivisionByInviteCode($request->get('invitation_code'));

        return response()->json([
            'data' => $data,
        ]);
    }

    public function sendInvitations(SendInvitationRequest $request, Division $division)
    {
        $status = $this->service->sendInvitations($request->all(), $division);

        return response()->json([
            'data' => ['status' => $status],
        ]);
    }
}
