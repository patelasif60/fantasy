<?php

namespace App\Http\Controllers\Manager;

use App\Models\Team;
use App\Models\Division;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Services\DivisionService;
use App\Services\TeamLineupService;
use App\Http\Controllers\Controller;
use App\Services\TransferService;
use App\Services\ValidateTransferFormationService;

class TeamLineupController extends Controller
{
    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * @var TeamLineup
     */
    protected $teamLineupService;

    /**
     * @var TeamService
     */
    protected $teamService;

    /**
     * TeamLineupController constructor.
     *
     * @param TeamLineupService $service
     */
    public function __construct(TeamLineupService $teamLineupService, DivisionService $service, TeamService $teamService, TransferService $transferService, ValidateTransferFormationService $validateTransferFormationService)
    {
        $this->teamLineupService = $teamLineupService;
        $this->divisionService = $service;
        $this->teamService = $teamService;
        $this->transferService = $transferService;
        $this->validateTransferFormationService = $validateTransferFormationService;
    }

    public function index(Division $division, Team $team, Request $request)
    {
        $this->authorize('isChairmanOrManagerOrParentleagueAndOwnDivision', [$division, $team]);
        
        $ownTeamFlg = $request->user()->can('ownTeam', $team);

        if ($request->user()->can('ownLeagues', $division)) {
            $ownTeamFlg = true;
        }

        $data = $this->teamLineupService->getLineupData($division, $team);
        $activePlayers = $data['activePlayers'];
        $subPlayers = $data['subPlayers'];
        $pitch = $data['pitch'];
        $availableFormations = $data['availableFormations'];
        $minMaxNumberForPosition = $data['minMaxNumberForPosition'];
        $teamStats = $data['team_stats'];
        $teamClubs = $data['teamClubs'];
        $futureFixturesDates = $data['futureFixturesDates'];
        $superSubFixtureDates = $data['superSubFixtureDates'];

        $seasons = $data['seasons'];
        $currentSeason = $data['currentSeason'];
        $playerSeasonStats = $data['playerSeasonStats'];
        $allowWeekendSwap = $data['allowWeekendSwap'];
        $enableSupersubs = $data['enableSupersubs'];
        $allowWeekendChanges = $data['allowWeekendChanges'];
        $isSupersubDisabled = $data['isSupersubDisabled'];
        $supersub_feature_live = $data['supersub_feature_live'];
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);

        return view('manager.team_lineup.index', compact('team', 'division', 'activePlayers', 'subPlayers', 'pitch', 'availableFormations', 'minMaxNumberForPosition', 'teamStats', 'teamClubs', 'futureFixturesDates', 'seasons', 'currentSeason', 'playerSeasonStats', 'ownTeamFlg', 'allowWeekendSwap', 'enableSupersubs', 'allowWeekendChanges', 'isSupersubDisabled', 'supersub_feature_live', 'superSubFixtureDates', 'columns'));
    }

    public function lineupView(Division $division, Team $team)
    {
        $data = $this->teamLineupService->getLineupData($division, $team);
        $activePlayers = $data['activePlayers'];
        $subPlayers = $data['subPlayers'];
        $pitch = $data['pitch'];

        return view('manager.team_lineup.team-line-view', compact('team', 'division', 'activePlayers', 'subPlayers', 'pitch'));
    }

    public function getPlayerStats(Division $division, Team $team)
    {
        $data = $this->teamLineupService->getPlayerStats($division, $team);

        return $data;
    }

    public function getPlayerStatsSold(Division $division, Team $team)
    {
        $data = $this->teamLineupService->getPlayerStatsSold($division, $team);

        return $data;
    }

    public function swapPlayer(Division $division, Team $team, Request $request)
    {
        $lineup_player = $request->get('lineup_player');
        $sub_player = $request->get('sub_player');
        $formation = $request->get('formation');

        $result = $this->transferService->subsValidation($division, $team, $lineup_player, $sub_player, $formation);

        if(Arr::has($result, 'status') && Arr::get($result, 'status') === 'success') {

            $result = $this->teamLineupService->swapPlayer($division, $team, $lineup_player, $sub_player, $formation);
        }

        return response()->json($result);
    }

    public function getPlayersForfixture(Division $division, Request $request)
    {
        $data = $request->all();

        if (! isset($data['date'])) {
            $data['date'] = now();
        }
        $data = $this->teamLineupService->getPlayersForFixture($data['team_id'], $data['date']);

        return $data;
    }

    public function getPlayersForfixtureForSwap(Division $division, Team $team)
    {
        $data = $this->teamLineupService->getLineupData($division, $team);

        return $data;
    }

    public function checkSuperSubData(Division $division, Team $team)
    {
        $result = $this->teamLineupService->checkSuperSubData($team);

        return response()->json($result);
    }

    public function checkTeamNextFixtureUpdatedData(Division $division, Request $request)
    {
        $result = $this->teamLineupService->checkTeamNextFixtureUpdatedData($request->all());

        return response()->json($result);
    }

    public function saveSuperSubData(Division $division, Request $request)
    {
        $data = $request->all();

        $result = $this->teamLineupService->saveSuperSubData($data);

        return response()->json($result);
    }

    public function sendConfirmationEmails(Division $division, Team $team)
    {
        $result = $this->teamLineupService->sendConfirmationEmails($team);

        return response()->json($result);
    }

    public function deleteSuperSubData(Division $division, Request $request)
    {
        $data = $request->all();

        $result = $this->teamLineupService->deleteSuperSubData($data);

        return response()->json($result);
    }

    public function deleteAllSuperSubData(Division $division, Request $request)
    {
        $data = $request->all();

        $result = $this->teamLineupService->deleteAllSuperSubData($data);

        return response()->json($result);
    }

    public function getTeamSuperSubFixtures(Division $division, Request $request)
    {
        $data = $request->all();

        $result = $this->teamLineupService->getTeamSuperSubFixtures($data);

        return response()->json($result);
    }

    public function getSupersubGuideCounter(Request $request)
    {
        $result = $this->teamLineupService->getSupersubGuideCounter();

        return response()->json($result);
    }

    public function more(Request $request, Division $division, Team $team, $competition = 'pl')
    {
        $selected = $competition;

        if (strtolower($competition) == 'pl') {
            $competition = 'Premier League';
        } else {
            $competition = 'FA Cup';
        }

        $conditions['competition'] = $competition;

        $playerStats = $this->teamLineupService->getTeamPlayersMoreStats($division, $team, $conditions);

        $columns = $this->divisionService->leagueStandingColumnHideShow($division);

        return view('manager.team_lineup.more', compact('team', 'division', 'playerStats', 'columns', 'selected'));
    }

    public function getSoldPlayers(Request $request, Division $division, Team $team)
    {
        $soldPlayer = $this->teamService->soldPlayers($team, $division);
        $soldPlayerIds = collect($soldPlayer)->pluck('id');

        return response()->json(['soldPlayer' => $soldPlayer, 'soldPlayerIds' => $soldPlayerIds]);
    }

    public function getHistoryPlayers(Request $request, Division $division, Team $team)
    {
        $playerHistory = $this->teamService->playerHistory($division, $team);

        return response()->json(['playerHistory' => $playerHistory]);
    }
}
