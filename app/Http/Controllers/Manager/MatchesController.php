<?php

namespace App\Http\Controllers\Manager;

use App\DataTables\InjuredPlayersDataTable;
use App\Enums\EventsEnum;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\GameWeek;
use App\Models\Season;
use App\Services\DivisionService;
use App\Services\GameWeekService;
use App\Services\LeagueReportService;
use App\Services\MatcheService;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use JavaScript;

class MatchesController extends Controller
{
    const CLUB_PREMIER = 1;
    protected $service;
    protected $playerService;
    protected $gameWeekService;
    protected $leagueReportService;

    public function __construct(MatcheService $service, GameWeekService $gameWeekService, LeagueReportService $leagueReportService, PlayerService $playerService, DivisionService $divisionService)
    {
        $this->service = $service;
        $this->gameWeekService = $gameWeekService;
        $this->leagueReportService = $leagueReportService;
        $this->playerService = $playerService;
        $this->divisionService = $divisionService;
    }

    public function index(Request $request, Division $division)
    {
        $gameWeeks = $this->gameWeekService->getAllGameWeeks($division);
        $currentGameWeek = $this->gameWeekService->getCurrentGameWeek();
        $clubs = $this->leagueReportService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $positions = $this->playerService->getAllPositions($division);
        $season = Season::all()->sortByDesc('start_at');
        $columns = $this->divisionService->leagueStandingColumnHideShow($division);
        $events = EventsEnum::toArray();

        JavaScript::put([
            'columns' => $columns,
            'events' => $events,
        ]);

        $matches = $matchePlayers = $assistPlayers = [];
        if (get_class($currentGameWeek) != 'stdClass') {
            $matches = $this->service->getGameWeekMatches($currentGameWeek, $division);
            $matchePlayers = $this->service->getMatchePlayers($currentGameWeek);
            $assistPlayers = $this->service->getAssistPlayers($currentGameWeek);
        }

        return view('manager.matches.index', compact('division', 'gameWeeks', 'currentGameWeek', 'matches', 'matchePlayers', 'assistPlayers', 'clubs', 'positions', 'season'));
    }

    public function gameWeekMatches(Request $request, Division $division, GameWeek $gameWeek)
    {
        $matches = $this->service->getGameWeekMatches($gameWeek, $division);
        $matchePlayers = $this->service->getMatchePlayers($gameWeek);
        $assistPlayers = $this->service->getAssistPlayers($gameWeek);

        return view('manager.matches.elements.match_card', compact('division', 'gameWeek', 'matches', 'matchePlayers', 'assistPlayers'));
    }

    public function gameWeekFixtureStats(Request $request, Division $division, GameWeek $gameWeek, Fixture $fixture)
    {
        $statsData = $this->service->gameWeekFixtureStats($division, $gameWeek, $fixture);

        $isCustomisedScoring = $statsData['isCustomisedScoring'];
        $isYRCardIncluded = $statsData['isYRCardIncluded'];
        $playerStats = $statsData['clubPlayers'];
        $columns = $statsData['columns'];
        $minsMatchPlayed = $statsData['minsMatchPlayed'];

        $fixture->setAttribute('time', get_date_time_in_carbon($fixture->date_time)->format('H:i'));
        $fixture->setAttribute('date', get_date_time_in_carbon($fixture->date_time)->format('jS F Y'));

        return view('manager.matches.elements.match_stats', compact('division', 'gameWeek', 'fixture', 'playerStats', 'isYRCardIncluded', 'isCustomisedScoring', 'columns', 'minsMatchPlayed'));
    }

    public function injuriesAndSuspensions(Division $division, InjuredPlayersDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}
