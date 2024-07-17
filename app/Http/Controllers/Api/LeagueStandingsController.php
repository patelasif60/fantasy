<?php

namespace App\Http\Controllers\Api;

use App\DataTables\MonthTeamRankingDataTable;
use App\DataTables\SeasonTeamRankingDataTable;
use App\DataTables\WeekTeamRankingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\Package;
use App\Models\Season;
use App\Services\TeamService;
use Illuminate\Http\Request;

class LeagueStandingsController extends Controller
{
    /**
     * @var TeamService
     */
    protected $service;

    /**
     * DivisionsController constructor.
     *
     * @param DivisionService $service
     */
    public function __construct(TeamService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Division $division)
    {
        if (! $request->user()->can('view', $division)) {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], JsonResponse::HTTP_FORBIDDEN);
        }

        $season = Season::with('gameweeks')->find(Season::getLatestSeason());
        $gameweeks = $season->gameweeks;

        $activeWeekId = $this->service->leagStandingAcitveGameWeek($gameweeks);

        $packages = Package::whereIn('id', $season->available_packages)->where('private_league', 'Yes')->pluck('name', 'id');

        $fixturesStart = Fixture::where('season_id', Season::getLatestSeason())->orderBy('date_time', 'asc')->first();
        $fixturesEnd = Fixture::where('season_id', Season::getLatestSeason())->orderBy('date_time', 'desc')->first();
        $months = collect();
        if($fixturesStart) {
            $months = carbon_get_months_between_dates($fixturesStart->date_time, $fixturesEnd->date_time);
        }

        $data['packages'] = $packages;
        $data['months'] = $months;
        $data['gameweeks'] = $gameweeks;
        $data['activeWeekId'] = $activeWeekId;
        $data['division'] = $division;

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getSeasonRanking(Request $request, SeasonTeamRankingDataTable $seasonTeamRankingDataTable)
    {
        return response()->json([
            'data' => $this->getResponseData($seasonTeamRankingDataTable),
        ]);
    }

    public function getMonthRanking(MonthTeamRankingDataTable $monthTeamRankingDataTable)
    {
        return response()->json([
            'data' => $this->getResponseData($monthTeamRankingDataTable),
        ]);
    }

    public function getWeekRanking(WeekTeamRankingDataTable $weekTeamRankingDataTable)
    {
        return response()->json([
            'data' => $this->getResponseData($weekTeamRankingDataTable),
        ]);
    }

    private function getResponseData($datatable)
    {
        $data = json_decode(json_encode($datatable->ajax()), true);
        $responseData['start'] = @request()->all()['start'];
        $responseData['length'] = @request()->all()['length'];
        $responseData['recordsTotal'] = $data['original']['recordsTotal'];
        $responseData['data'] = $data['original']['data'];

        return $responseData;
    }

    public function teamDetails(Request $request, Division $division)
    {
        $players = $this->service->getTeamPlayerPoints($division, $request->all()['team_id']);

        $s3Url = config('fantasy.aws_url').'/tshirts/';
        foreach ($players as $player) {
            $position = player_position_short($player->position);
            if ($position == 'GK') {
                $player->tshirt = $s3Url.$player->short_code.'/GK.png';
            } else {
                $player->tshirt = $s3Url.$player->short_code.'/player.png';
            }
        }

        return response()->json([
            'players' => $players,
        ]);
    }
}
