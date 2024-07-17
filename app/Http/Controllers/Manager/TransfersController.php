<?php

namespace App\Http\Controllers\Manager;

use JavaScript;
use App\Models\Team;
use App\Models\Season;
use App\Models\Fixture;
use App\Models\Transfer;
use App\Enums\YesNoEnum;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\HistoryPeriodEnum;
use Illuminate\Http\JsonResponse;
use App\Services\AuctionService;
use App\Services\TransferService;
use App\Http\Controllers\Controller;
use App\Enums\HistoryTransferTypeEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Repositories\TeamLineupRepository;
use App\Repositories\TeamPlayerRepository;
use App\Services\ValidateFormationService;
use App\DataTables\ChangeHistoryDataTable;
use App\Jobs\ProcessTeamLineUpCheckAndReset;
use App\Services\ValidateTransferFormationService;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class TransfersController extends Controller
{
    /**
     * @var TransferService
     */
    protected $service;
    protected $validateFormationService;

    protected $teamPlayerRepository;

    protected $validateTransferFormationService;

    protected $transferService;

    /**
     * TransfersController constructor.
     *
     * @param TransferService $transferService
     */
    public function __construct(AuctionService $service, ValidateFormationService $validateFormationService, TeamPlayerRepository $teamPlayerRepository, ValidateTransferFormationService $validateTransferFormationService, TransferService $transferService, TeamLineupRepository $teamLineupRepository)
    {
        $this->validateTransferFormationService = $validateTransferFormationService;
        $this->teamPlayerRepository = $teamPlayerRepository;
        $this->validateFormationService = $validateFormationService;
        $this->transferService = $transferService;
        $this->service = $service;
        $this->teamLineupRepository = $teamLineupRepository;
    }

    /**
     * Show the manager home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Division $division, Request $request)
    {
        $team = $request->user()->consumer->ownTeamDetails($division);

        $this->authorize('isChairmanOrManager', [$division, $team]);

        if (config('fantasy.transfer_feature_live') != 'true') {
            return abort(403);
        }

        if ($division->getOptionValue('allow_weekend_changes') == YesNoEnum::YES) {
            $allowWeekendSwap = true;
        } else {
            $chkFlag = Fixture::checkFixtureForSwap();
            $allowWeekendSwap = ! $chkFlag ? true : false;
        }

        return view('manager.divisions.transfers.index', compact('division', 'allowWeekendSwap'));
    }

    public function transferTeams(Division $division)
    {
        $this->authorize('transferChairman', $division);
        $teams = $division->divisionTeams()->approve()->get();

        return view('manager.divisions.transfers.transfer_teams', compact('division', 'teams'));
    }

    public function transferPlayers(Division $division, Team $team)
    {
        $this->authorize('isChairmanOrManagerAndOwnDivision', [$division, $team]);

        if (auth()->user()->cannot('isTransferEnabled', $division)) {

            return abort(403);
        }

        $teamPlayers = $this->transferService->getTeamTransferPlayersPositionWise($division, $team);

        foreach ($teamPlayers as $playerKey => $playerValue) {
            if ($playerValue->count()) {
                foreach ($playerValue as $key => $value) {
                    $dbDataArray[] = ['playerName'=> get_player_name('lastName', $value->player_first_name, $value->player_last_name), 'playerId'=>$value->player_id, 'teamId' =>$value->team_id, 'position'=>player_position_short($playerKey), 'shortCode'=>$value->short_code, 'totalPoints'=>$value->total_points, 'clubId'=>$value->club_id, 'transferValue'=>$value->transfer_value, 'plyerModelName'=>get_player_name('firstNameFirstCharAndFullLastName', $value->player_first_name, $value->player_last_name)]; //'nextFixture'=>$value->nextFixture,
                }
            }
        }
        $dbDatastr = json_encode($dbDataArray);
        $teamBudget = number_clean($team->team_budget == null ? 0 : $team->team_budget);
        $clubs = $this->transferService->getClubs();
        $positions = $this->transferService->getPositions($division);
        $totalTeamPlayers = $team->activeTeamPlayers->count();
        JavaScript::put([
            'defaultSquadSize' => $division->getOptionValue('default_squad_size'),
            'teamBudget' => $teamBudget,
            'team' => $team,
            //'teamClubsPlayer' => $this->transferService->getTeamClubsPlayer($team),
            'teamClubsPlayer' => array_count_values($this->transferService->getTeamClubsPlayer($team)->pluck('club_id')->toArray()),
            'teamClubsPlayer_revert' => $this->transferService->getTeamClubsPlayer($team),
            'maxClubPlayers' => $division->getOptionValue('default_max_player_each_club'),
            'division' => $division,
            'totalTeamPlayers' => $totalTeamPlayers,
            'mergeDefenders' => $division->getOptionValue('merge_defenders'),
            'defensiveMidfields' => $division->getOptionValue('defensive_midfields'),
            'availablePostions' => $this->validateFormationService->getEnabledPositions($division, $this->transferService->getTeamPlayerPostions($team)),
            'assetUrl' => asset('assets/frontend'),
            'playerPositions' => TeamPointsPositionEnum::toSelectArray(),
            'allPositionEnum' => ALLPositionEnum::toArray(),
            'playerData' => $dbDatastr,
            'teamPlayers'=>$teamPlayers,
            //'chkFixture' => Fixture::checkFixtureForSwap(),
            'chkDefenderPosition' => in_array('Defender', $positions),
            'chkDefenciveMidfilderPosition'=> in_array('Defensive midfielder', $positions),
        ]);

        return view('manager.divisions.transfers.transfer_players', compact('division', 'team', 'teamPlayers', 'teamBudget', 'clubs', 'positions', 'totalTeamPlayers', 'division', 'dbDataArray', 'dbDatastr'));
    }

    /**
     * Fetch the list of all agent players of division.
     *
     * @param Division $division
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Division $division, Team $team)
    {
        $this->authorize('transferChairmanOrManager', $division);
        $totalTeamPlayers = $team->activeTeamPlayers->count();
        $request = $request->all();
        $teamPlayers = $this->transferService->getTeamTransferPlayersPositionWise($division, $team);
        $teamPlayersArray = json_decode($request['dbdata']);

        foreach ($teamPlayers as $playerKey => $playerValue) {
            if ($playerValue->count()) {
                foreach ($playerValue as $key => $value) {
                    $dbDataArray[] = ['playerName'=> get_player_name('lastName', $value->player_first_name, $value->player_last_name), 'playerId'=>$value->player_id, 'teamId' =>$value->team_id, 'position'=>player_position_short($playerKey), 'shortCode'=>$value->short_code, 'totalPoints'=>$value->total_points, 'clubId'=>$value->club_id, 'transferValue'=>$value->transfer_value, 'plyerModelName'=>get_player_name('firstNameFirstCharAndFullLastName', $value->player_first_name, $value->player_last_name)]; //'nextFixture'=>$value->nextFixture,
                }
            }
        }
        $dbDatastr = json_encode($dbDataArray);
        $teamPlayersArrayDB = json_decode($dbDatastr);

        if (json_decode($request['transferData'])) {
            $transferData = json_decode($request['transferData']);
            $transferPlayersArray = (array_values(array_column($transferData, 'boughtPlayerId')));
            $getTransferPlayerOtherTeamCount = $this->transferService->getTransferPlayerOtherTeamCount($division, $transferPlayersArray);

            if ($getTransferPlayerOtherTeamCount) {

                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.already_in_team.error')], JsonResponse::HTTP_OK);
            }

            $transferPlayersSoldArray = (array_values(array_column($transferData, 'soldPlayerId')));
            $getTransferPlayerOtherTeamCount = $this->transferService->getTransferPlayerInTeamCount($team, $transferPlayersSoldArray);

            if (!$getTransferPlayerOtherTeamCount) {

                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.line_up.error')], JsonResponse::HTTP_OK);
            }

            foreach ($teamPlayersArrayDB as $key => $value) {
                if (in_array($value->playerId, $transferPlayersSoldArray)) {
                    unset($teamPlayersArrayDB[$key]);
                }
            }
            foreach ($teamPlayersArray as $key => $value) {
                if (in_array($value->playerId, $transferPlayersArray)) {
                    array_push($teamPlayersArrayDB, $value);
                }
            }
            $teamPlayersArray = $teamPlayersArrayDB;

            $totalPlayers = array_values(array_column($teamPlayersArray, 'playerId'));
            $players = $this->transferService->getTeamPlayerPostions($team, $totalPlayers);
            if (array_sum($players) != $totalTeamPlayers) {

                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.squad_size.error')], JsonResponse::HTTP_OK);
            }
            $mergeDefenders = $division->getOptionValue('merge_defenders');
            $availableFormations = $division->getOptionValue('available_formations');
            if (! $this->validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $players)) {

                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.formation.error')], JsonResponse::HTTP_OK);
            }
            $this->maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
            $clubArray = (array_count_values(array_column($teamPlayersArray, 'clubId')));
            $clubPlayerFlag = array_map(function ($index) {
                if ($index > $this->maxClubPlayer) {
                    return 'false';
                }
            }, $clubArray);
            if (in_array('false', $clubPlayerFlag)) {

                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.club_quota.error')], JsonResponse::HTTP_OK);
            }
            // $free_agent_transfer_after = $division->getOptionValue('free_agent_transfer_after');
            // $dateOfTransfer = $division->getOptionValue('auction_closing_date');
            // if ($free_agent_transfer_after == 'seasonStart') {
            //     $currentSeason = Season::find(Season::getLatestSeason());
            //     $dateOfTransfer = $currentSeason['start_at'];
            // }
            // $transfer = Transfer::where('team_id', $team->id)->where('transfer_type', 'transfer')->where('transfer_date', '>', $dateOfTransfer)->count();

            $transfer = Team::where('id', $team->id)->first();
            $season_free_agent_transfer_limit = $division->getOptionValue('season_free_agent_transfer_limit');
            if (($transfer->season_quota_used + count($transferPlayersArray)) > $season_free_agent_transfer_limit) {

                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.seasons_quota.error')], JsonResponse::HTTP_OK);
            }
            // $transfer = Transfer::where('team_id', $team->id)->where('transfer_type', 'transfer')->whereRaw('MONTH(transfer_date) = MONTH(CURRENT_DATE())')->count();
            $monthly_free_agent_transfer_limit = $division->getOptionValue('monthly_free_agent_transfer_limit');
            if (($transfer->monthly_quota_used + count($transferPlayersArray)) > $monthly_free_agent_transfer_limit) {
                
                return response()->json(['status' => 'error', 'error' => trans('messages.transfer.monthly_quota.error')], JsonResponse::HTTP_OK);
            }
        }

        return response()->json(['status' => 'sucess'], JsonResponse::HTTP_OK);
    }

    public function store(Request $request, Division $division, Team $team)
    {
        $this->authorize('transferChairmanOrManager', $division);

        $data = $request->all();

        $transferData = json_decode($request->get('transferData'));

        if ($request->get('transferData') && count($transferData) > 0) {

            $this->teamPlayerRepository->transferPlayers($data);

            //Lineup Reset
            ProcessTeamLineUpCheckAndReset::dispatch($division, $team);

            return redirect(route('manage.team.lineup', ['division' => $division, 'team'=> $team]));
        }

        return redirect()->back();
    }

    public function addPlayers(Request $request, Division $division, Team $team)
    {
        $this->authorize('transferChairmanOrManager', $division);
        
        $data = $request->all();
        $dbDataArray = json_decode($data['player']);
        $teamPlayers = $this->transferService->getTeamTransferPlayersPositionWise($division, $team);

        return view('manager.divisions.transfers.partials.player', compact('division', 'team', 'teamPlayers', 'dbDataArray'));
    }

    public function getTransferPlayers(Request $request, Division $division, Team $team)
    {
        $this->authorize('transferChairmanOrManager', $division);
        
        $players = $this->transferService->getTransferPlayers($division, $team, $request->all());

        return response()->json([
            'data' => $players,
        ]);
    }

    public function history(Division $division)
    {
        $transferTypes = HistoryTransferTypeEnum::toSelectArray();
        $periodEnum = HistoryPeriodEnum::toArray();
        JavaScript::put([
            'transferTypes' => $transferTypes,
            'division'      => $division,
        ]);

        return view('manager.divisions.transfers.history', compact('division', 'transferTypes', 'periodEnum'));
    }

    public function divisionTransferHistory(Request $request, Division $division, ChangeHistoryDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}

