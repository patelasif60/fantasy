<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\GameWeek;
use App\Services\DivisionService;
use App\Services\GameWeekService;
use App\Services\LeagueReportService;
use App\Services\MatcheService;
use App\Services\PlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function matches(Request $request, Division $division, GameWeek $gameWeek)
    {
        $s3Url = config('fantasy.aws_url').'/tshirts/';

        $gameWeeks = $this->gameWeekService->getAllGameWeeks($division);
        $currentGameWeek = $this->gameWeekService->getCurrentGameWeek();
        $clubs = $this->leagueReportService->getClubs(['is_premier' => self::CLUB_PREMIER]);
        $positions = $this->playerService->getAllPositions($division);

        $matches = $matchePlayers = $assistPlayers = [];

        if (get_class($currentGameWeek) != 'stdClass') {
            $matches = $this->service->getGameWeekMatches($currentGameWeek, $division);
            $matchePlayers = $this->service->getMatchePlayers($currentGameWeek);
            $assistPlayers = $this->service->getAssistPlayers($currentGameWeek);
        }
        foreach ($matches as $match) {
            $match->home_team_tshirt = $s3Url.$match->home_team->short_code.'/player.png';
            $match->home_team_short_code = strtolower($match->home_team->short_code);
            $match->home_team_short_name = $match->home_team->short_name;
            $match->away_team_short_name = $match->away_team->short_name;
            $match->away_team_tshirt = $s3Url.$match->away_team->short_code.'/player.png';
            $match->away_team_short_code = strtolower($match->away_team->short_code);
        }

        return response()->json(['status' => 'success', 'data' => $matches], JsonResponse::HTTP_OK);
    }

    public function gameWeekMatches(Request $request, Division $division, GameWeek $gameWeek)
    {
        $matches = $this->service->getGameWeekMatches($gameWeek, $division);
        $matchePlayers = $this->service->getMatchePlayers($gameWeek);
        $assistPlayers = $this->service->getAssistPlayers($gameWeek);

        foreach ($matches as $match) {
            $match->home_team_tshirt = player_tshirt($match->home_team->short_code, '');
            $match->home_team_short_code = strtolower($match->home_team->short_code);
            $match->home_team_short_name = $match->home_team->short_name;
            $match->away_team_short_name = $match->away_team->short_name;
            $match->away_team_tshirt = player_tshirt($match->away_team->short_code, '');
            $match->away_team_short_code = strtolower($match->away_team->short_code);
        }

        return response()->json(['status' => 'success', 'data' => $matches, 'matchePlayers' => $matchePlayers, 'assistPlayers' => $assistPlayers ], JsonResponse::HTTP_OK);
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

        return response()->json(['status' => 'success', 'data' => $fixture, 'stats' => $statsData, 'minsMatchPlayed' => $minsMatchPlayed, 'columns' => $columns], JsonResponse::HTTP_OK);
    }
}
