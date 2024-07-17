<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\Team;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SwapController extends Controller
{
    /**
     * @var transferService
     */
    protected $transferService;

    /**
     * TransferController constructor.
     */
    public function __construct(TransferService $TransferService)
    {
        $this->transferService = $TransferService;
    }

    public function getTeams(Division $division, Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $division->divisionTeams()
                    ->approve()
                    ->get(),

        ], JsonResponse::HTTP_OK);
    }

    public function getTeamPlayers(Division $division, Team $team)
    {
        $players = $this->transferService->getTeamPlayers($division, $team->id);
        $players->map(function ($item, $key) {
            $item->position = $item->position;
            if ($item->position == 'DMF') {
                $item->position = 'DM';
            }
        });

        return response()->json(
            ['status' => 'success',
                'checkFixture' => Fixture::checkFixtureForSwap(),
                'data' => $players,
            ],
             JsonResponse::HTTP_OK
        );
    }

    public function swapPlayers(Division $division, Request $request)
    {
        $data = $request['swap_data'];
        $possible = $this->transferService->checkTransferPossible($data);

        if ($possible['status']) {
            $transfer = $this->transferService->swapPlayersContract($division, $data);

            if ($transfer) {
                return response()->json(['status'=> 'success', 'message'=> trans('messages.swap.saved.success')], JsonResponse::HTTP_OK);
            }

            return response()->json(['status'=> 'error', 'message'=> trans('messages.swap.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['status'=> 'error', 'message'=> $possible['message']], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
