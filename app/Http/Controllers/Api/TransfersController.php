<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Team;
use App\Enums\YesNoEnum;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\Season;
use App\Models\Transfer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\HistoryPeriodEnum;
use App\Services\AuctionService;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Enums\HistoryTransferTypeEnum;
use App\Services\AuctionCommanService;
use App\Repositories\TeamPlayerRepository;
use App\Services\ValidateFormationService;
use App\Jobs\ProcessTeamLineUpCheckAndReset;
use App\Http\Resources\Team as TeamResource;
use App\Services\ValidateTransferFormationService;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class TransfersController extends Controller
{
    protected $service;

    /**
     * TransferController constructor.
     *
     * @param TransferService $service
     */
    public function __construct(TransferService $service, AuctionService $auctionService, ValidateFormationService $validateFormationService, TeamPlayerRepository $teamPlayerRepository, ValidateTransferFormationService $validateTransferFormationService)
    {
        $this->service = $service;
        $this->auctionService = $auctionService;
        $this->validateFormationService = $validateFormationService;
        $this->teamPlayerRepository = $teamPlayerRepository;
        $this->validateTransferFormationService = $validateTransferFormationService;
    }

    public function showTransfersMenu(Division $division, Request $request)
    {
        $user = $request->user();
        $consumer = $user->consumer;
        $team = $consumer->ownTeamDetails($division);

        if (! $user->can('isChairmanOrManager', [$division,$team])) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }


        if (! $user->can('ownLeagues', $division)) {
            $ownTeams = $division->divisionTeams()
                        ->with('consumer.user')
                        ->approve()
                        ->where('manager_id', $consumer->id)
                        ->get();
        } else {
            $ownTeams = $division->divisionTeams()
                        ->with('consumer.user')
                        ->approve()
                        ->get();
        }

        if ($division->getOptionValue('allow_weekend_changes') == YesNoEnum::YES) {
            $allowWeekendSwap = true;
        } else {
            $chkFlag = Fixture::checkFixtureForSwap();
            $allowWeekendSwap = ! $chkFlag ? true : false;
        }

        return response()->json([
            'transfer_button' => $user->can('isTransferEnabled', $division),
            'swaps_button' => $user->can('ownLeagues', $division) ? true : false,
            'enter_sealed_bid_button' => $user->can('ownTeam', $division),
            'isTransferEnabled' => $user->can('isTransferEnabled', $division),
            'allowWeekendSwap' => $allowWeekendSwap,
            'ownTeam' => $team ? new TeamResource($team->load('consumer')) : [],
            'ownAllTeams' => TeamResource::collection($ownTeams),
        ]);
    }

    public function history(Division $division)
    {
        try {
            $data['transferTypes'] = HistoryTransferTypeEnum::toSelectArray();
            $data['periodEnum'] = HistoryPeriodEnum::toArray();

            return response()->json(['status' => 'success', 'data' => $data], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    // public function divisionTransferHistory(Request $request, Division $division)
    // {
    //     try {
    //         $transfers = $this->service->divisionTransferHistory($division, $request->all());

    //         return response()->json(
    //             ['status' => 'success',
    //                 'data' => $transfers,
    //             ],
    //              JsonResponse::HTTP_OK
    //          );
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => 'Invalid request'], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    //     }
    // }

    public function transferTeams(Division $division, Request $request)
    {
        if (! $request->user()->can('transferChairmanOrManager', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $divisionTeams = $this->service->getDivisionTeamsDetails($division);

        return response()->json(
                    ['status' => 'success',
                        'data' => $divisionTeams,
                    ],
                     JsonResponse::HTTP_OK
                 );
    }

    public function getTeamsDetails(Division $division, Team $team, Request $request)
    {
        if (! $request->user()->can('transferChairmanOrManager', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $availablePostions = $this->validateFormationService->getEnabledPositions($division, $this->service->getTeamPlayerPostions($team));
        $formatedAvailablePostions = collect($availablePostions)->map(function ($position) {
            return player_position_short($position);
        })->toArray();

        $players = $this->service->getTeamTransferPlayersPositionWise($division, $team);
        $formatedPlayers = [];
        $playersCollection = collect($players)->map(function ($item, $key) use (&$formatedPlayers,$division) {
            $playerPositions = $item->map(function ($player) use ($division) {
                $player->position = $division->getPositionShortCode(player_position_short($player->position));
                $player->tshirt = player_tshirt($player->short_code, $player->position);

                return $player;
            });
            $pos = player_position_short($key);
            if (player_position_short($key) == 'DMF') {
                $pos = 'DM';
            }

            return $formatedPlayers[$pos] = $playerPositions;
        });

        $auctionCommanService = app(AuctionCommanService::class);
        $positions = $auctionCommanService->getPositions($division);

        $data['team'] = $this->service->getTeamDetails($division, $team);
        $data['teamClubsPlayer'] = array_count_values($this->service->getTeamClubsPlayer($team)->pluck('club_id')->toArray());
        $data['maxClubPlayers'] = $division->getOptionValue('default_max_player_each_club');
        $data['mergeDefenders'] = $division->getOptionValue('merge_defenders');
        $data['defensiveMidfields'] = $division->getOptionValue('defensive_midfields');
        $data['availablePostions'] = $formatedAvailablePostions;
        $data['clubs'] = $this->service->getClubs();
        $data['positions'] = $positions;
        $data['players'] = $formatedPlayers;
        $data['pitch'] = config('fantasy.pitch_url');
        $data['messages'] = __('messages.transfer');

        return response()->json( ['status' => 'success', 'data' => $data, ], JsonResponse::HTTP_OK );
    }

    public function getAllPlayers(Request $request, Division $division, Team $team)
    {
        if (! $request->user()->can('transferChairmanOrManager', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if ($request['position']) {
            if ($request['position'] == 'DM') {
                $request['position'] = 'DMF';
            }
            $request['position'] = player_position_full($request['position']);
        }
        $players = $this->service->getTransferPlayers($division, $team, $request->all());
        $players->map(function ($item, $key) use ($division) {
            $item->position = $item->playerPositionShort;
            $item->tshirt = player_tshirt($item->short_code, $item->position);
        });

        return response()->json(
            ['status' => 'success',
                'checkFixture' => Fixture::checkFixtureForSwap(),
                'data' => $players,
            ],
             JsonResponse::HTTP_OK
         );
    }

    public function store(Request $request, Division $division, Team $team)
    {
        if (! $request->user()->can('transferChairmanOrManager', $division)) {

            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        if (!$request->has('transferData') || count($request->get('transferData',[])) <= 0 ) {

            return response()->json(['status' => 'error', 'message' => __('messages.data.saved.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transferData = collect($request->get('transferData',[]));
        $boughtPlayerIds = $transferData->keyBy('boughtPlayerId');
        $soldPlayerIds = $transferData->keyBy('soldPlayerId');
        

        $players = $this->service->getPlayersForTransfers($boughtPlayerIds->keys());
        $players = $players->keyBy('id');
        $totalTeamPlayers = $team->activeTeamPlayers->count();       
        $teamPlayers = $this->service->getTeamTransferPlayersPositionWise($division, $team);

        $afterTransferTeamPlayers = [];
        $originalTeamPlayers = [];
        foreach ($teamPlayers as $playerKey => $playerValue) {
            if ($playerValue->count()) {
                foreach ($playerValue as $key => $value) {
                    $player_id = $value->player_id;
                    $club_id = $value->club_id;
                    $newdt = $soldPlayerIds->get($value->player_id,[]);
                    if($newdt) {
                        $player = $players->get($newdt['boughtPlayerId'],[]);
                        if($player) {
                            $player_id = $player->id;
                            $club_id = $player->club_id;
                        }
                    }
                    $afterTransferTeamPlayers[] = ['playerId' => $player_id, 'clubId' => $club_id ];
                    $originalTeamPlayers[] = ['playerId'=> $value->player_id, 'clubId'=> $value->club_id];
                }
            }
        }

        $budget = $team->team_budget == null ? 0 : $team->team_budget;
        $budget =  ($budget + $transferData->sum('soldAmount')) - $transferData->sum('boughtAmount');

        if ($budget < 0) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.budget.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }


        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $availableFormations = $division->getOptionValue('available_formations');

        $transferPlayersArray = $boughtPlayerIds->keys()->toArray();
        $getTransferPlayerOtherTeamCount = $this->service->getTransferPlayerOtherTeamCount($division, $transferPlayersArray);

        if ($getTransferPlayerOtherTeamCount) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.already_in_team.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transferPlayersSoldArray = $soldPlayerIds->keys()->toArray();
        $getTransferPlayerOtherTeamCount = $this->service->getTransferPlayerInTeamCount($team, $transferPlayersSoldArray);

        if (!$getTransferPlayerOtherTeamCount) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.line_up.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

       
        foreach ($originalTeamPlayers as $key => $value) {
            if (in_array($value['playerId'], $transferPlayersSoldArray)) {
                unset($originalTeamPlayers[$key]);
            }
        }

        foreach ($afterTransferTeamPlayers as $key => $value) {
            if (in_array($value['playerId'], $transferPlayersArray)) {
                array_push($originalTeamPlayers, $value);
            }
        }

        $totalPlayers = collect($originalTeamPlayers)->keyBy('playerId')->keys();
        $players = $this->service->getTeamPlayerPostions($team, $totalPlayers);

        if (array_sum($players) != $totalTeamPlayers) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.squad_size.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! $this->validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $players)) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.formation.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');

        $playerGroupByClub = collect($afterTransferTeamPlayers)->groupBy('clubId')->map->count();

        if($playerGroupByClub->max() > $maxClubPlayer) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.club_quota.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transfer = $team;
        $season_free_agent_transfer_limit = $division->getOptionValue('season_free_agent_transfer_limit');
        if (($transfer->season_quota_used + count($transferPlayersArray)) > $season_free_agent_transfer_limit) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.seasons_quota.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $monthly_free_agent_transfer_limit = $division->getOptionValue('monthly_free_agent_transfer_limit');
        if (($transfer->monthly_quota_used + count($transferPlayersArray)) > $monthly_free_agent_transfer_limit) {

            return response()->json(['status' => 'error', 'message' => trans('messages.transfer.monthly_quota.error')], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $request->all();

        $data['teamBudget'] = $budget;

        $this->teamPlayerRepository->transferPlayersApi($data, $team);

        //Lineup Reset
        ProcessTeamLineUpCheckAndReset::dispatch($division, $team);

        return response()->json(['status'=> 'success', 'message'=> trans('messages.transfer.saved.success')], JsonResponse::HTTP_OK);
    }
}
