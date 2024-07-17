<?php

namespace App\Http\Controllers\Manager;

use App\DataTables\HallofFameDataTable;
use App\DataTables\InsOutDataTable;
use App\DataTables\MorePlayerListDataTable;
use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Services\DivisionService;
use App\Services\LeagueReportService;
use App\Services\PlayerService;
use App\Services\TeamLineupService;
use Illuminate\Http\Request;
use JavaScript;

class PlayersController extends Controller
{
    const CLUB_PREMIER = 1;
    /**
     * @var LeagueReport
     */
    protected $leagueReportService;

    /**
     * @var TeamLineupService
     */
    protected $teamLineup;

    /**
     * @var PlayerService
     */
    protected $playerService;

    /**
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * PlayersController constructor.
     *
     * @param TeamLineupService $teamLineup
     */
    public function __construct(TeamLineupService $teamLineup, LeagueReportService $leagueReportService, PlayerService $playerService, DivisionService $divisionService)
    {
        $this->leagueReportService = $leagueReportService;
        $this->teamLineup = $teamLineup;
        $this->playerService = $playerService;
        $this->divisionService = $divisionService;
    }

    public function getMorePLayersList(Division $division)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        $clubs = $this->leagueReportService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $positions = $this->playerService->getAllPositions($division);

        $columns = $this->divisionService->leagueStandingColumnHideShow($division);
        $events = EventsEnum::toArray();

        JavaScript::put([
            'columns' => $columns,
            'events' => $events,
        ]);

        return view('manager.more.players', compact('division', 'positions', 'clubs'));
    }

    public function players(Division $division, MorePlayerListDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    public function insout(Division $division, InsOutDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    public function getPlayerStatsBySeason(Division $division, Team $team, Player $player, Season $season)
    {
        $stats = $this->teamLineup->getPlayerStatsBySeason($team, $player, $season);

        return $stats;
    }

    public function exportToPdf(Division $division, Request $request)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $this->playerService->getAllPlayers($division, $request->all(), 'pdf');
    }

    public function exportToXlsx(Division $division, Request $request)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $this->playerService->getAllPlayers($division, $request->all(), 'excel');
    }

    public function playersDetails(Division $division, Request $request)
    {
        $playerDetails = $this->playerService->getPlayerDetails($request->get('player_id'));

        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        $currentSeason = Season::find(Season::getLatestSeason());

        // Ticket #FL-1463
        // $season = $currentSeason->isPreSeasonState() ? Season::find(Season::getPreviousSeason()) : $currentSeason;
        $season = $currentSeason;

        $stats = $this->teamLineup->getPlayerStatsBySeasonSingle($division, $request->get('player_id'), $season->id);

        $stats = $stats[$request->get('player_id')];
        $historyStats = $this->playerService->historyDataWeb($request->get('player_id'));
        $historyData[] = [];

        $playerPositions = PositionsEnum::toSelectArray();
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);
        $count = 0;
        foreach ($historyStats as $historyStatsKey => $historyStatsValue) {
            $goal = isset($divisionPoints[$historyStatsValue->position][EventsEnum::GOAL]) && $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL] ? $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL] : 0;

            $assist = isset($divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST]) && $divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST] ? $divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST] : 0;

            $goalConceded = isset($divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED] : 0;

            $cleanSheet = isset($divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET] : 0;

            $appearance = isset($divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE]) && $divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE] ? $divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE] : 0;

            $historyData[$count]['name'] = $historyStatsValue->season->name;
            $historyData[$count]['played'] = $historyStatsValue->played;
            $historyData[$count]['appearance'] = $historyStatsValue->appearance;
            $historyData[$count]['goal'] = $historyStatsValue->goal;
            $historyData[$count]['assist'] = $historyStatsValue->assist;
            $historyData[$count]['clean_sheet'] = $historyStatsValue->clean_sheet;
            $historyData[$count]['goal_conceded'] = $historyStatsValue->goal_conceded;
            
            $historyData[$count]['total'] = $historyData[$count]['goal'] * $goal + $historyData[$count]['assist'] * $assist + $historyData[$count]['clean_sheet'] * $cleanSheet + $historyData[$count]['goal_conceded'] * $goalConceded + $historyData[$count]['appearance'] * $appearance;
            $count++;
        }

        return view('manager.more.players_details', compact('playerDetails', 'division', 'stats', 'historyData', 'historyStats'));
    }

    public function historyPlayerdata(Division $division, HallofFameDataTable $dataTable)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);

        return $dataTable->ajax();
    }

    public function historyLineupPage(Division $division, Request $request)
    {
        $this->authorize('isChairmanOrManagerOrParentleague', [$division, auth()->user()->consumer->ownTeamDetails($division)]);
        $historyStats = $this->playerService->historyData($division, $request->get('player_id'));

        return $historyStats;
    }
}
