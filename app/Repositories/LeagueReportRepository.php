<?php

namespace App\Repositories;

use App\Enums\TeamPointsPositionEnum;
use App\Jobs\SendLeagueReportEmail;
use App\Models\Division;
use App\Models\DivisionTeam;
use App\Models\FixtureStats;
use App\Models\GameWeek;
use App\Models\Season;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class LeagueReportRepository
{
    public function sendEmail(Division $division, User $user, $reportFile)
    {
        if ($reportFile) {
            $gameweek = GameWeek::current();
            $message['divisionName'] = $division->name;
            $message['displayName'] = $user->first_name.' '.$user->last_name;

            $message['start'] = $gameweek->season->start_at->toDateString();
            $message['end'] = $gameweek->end->toDateString();

            $emailJob = (new SendLeagueReportEmail($user->email, $message, utf8_encode($reportFile)));
            dispatch($emailJob);

            return true;
        }

        return false;
    }

    public function buildPDFReportFile(Division $division, User $user, $data)
    {
        $date = Carbon::now()->format('d/m/Y');
        $gameweek = $data['gameweek'];
        $name = 'Auction - Division - League Report - Fantasy League';
        $divisionName = $division->name.' (Pin:'.$division->id.') | Week No. '.$gameweek['number'];

        $header = view('manager.leaguereports.pdf.header', compact('date', 'name', 'divisionName', 'gameweek'));

        $months = $this->getCurrentSeasonMonths();

        //Build Pages of Report
        $leaguePages = [
            'gameweek'      => $gameweek,
            'months'        => $months,
            'currentMonth'  => Carbon::now()->format('n'),
            'leagueTable'   => $data['leagueTable'],
            'monthlyForm'   => json_encode($data['monthlyForm']),
            'leagueSeries'  => json_encode($data['leagueSeries']),
        ];

        $playerPages = [
            'gameweek'     => $gameweek,
            'teamPlayers'  => $data['teamPlayers'],
        ];

        $positionPages = [
            'currentMonth' => Carbon::now()->format('n'),
            'formGuide'    => $data['formGuide'],
        ];

        $agentPages = [
            'currentMonth' => Carbon::now()->format('n'),
            //'freeAgents'    => $data['freeAgents'],
        ];

        $pages[] = view('manager.leaguereports.pdf.league', $leaguePages);
        $pages[] = view('manager.leaguereports.pdf.team-players', $playerPages);
        $pages[] = view('manager.leaguereports.pdf.free-agents', $agentPages);
        $pages[] = view('manager.leaguereports.pdf.form-guide', $positionPages);
        $pages[] = view('manager.leaguereports.pdf.summary', $playerPages, $leaguePages);

        $pdf = PDF::loadView('manager.leaguereports.pdf.index', ['pages' => $pages, 'header'=>$header]);

        $pdf->setOption('print-media-type', true);
        $pdf->setOption('header-left', $date);
        $pdf->setOption('header-right', $name);
        $pdf->setOption('footer-right', '[page]/[topage]');

        return $pdf->output();
    }

    public function getCurrentGameWeek()
    {
        return GameWeek::current();
    }

    public function getCurrentSeasonMonths()
    {
        $season = Season::find(Season::getLatestSeason());

        return get_month_between_dates($season->start_at->toDateString(), $season->end_at->toDateString());
    }

    public function getMonthlyFormData($division)
    {
        $teamIds = [];
        foreach ($division->divisionTeams as $team) {
            $teamIds[] = $team->id;
        }

        $season = Season::getLatestSeason();

        return DivisionTeam::join('teams', 'teams.id', '=', 'division_teams.team_id')
        ->leftJoin(
            DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id AND fixtures.season_id = $season )"),
            function ($join) {
                $join->on('team_points.team_id', '=', 'division_teams.team_id');
            }
        )
        ->select(
            'teams.name as teamName',
            'teams.id as teamId',
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 1 THEN COALESCE( team_points.total,0) END) AS Jan'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 2 THEN COALESCE( team_points.total,0) END) AS Feb'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 3 THEN COALESCE( team_points.total,0) END) AS Mar'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 4 THEN COALESCE( team_points.total,0) END) AS Apr'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 5 THEN COALESCE( team_points.total,0) END) AS May'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 6 THEN COALESCE( team_points.total,0) END) AS Jun'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 7 THEN COALESCE( team_points.total,0) END) AS Jul'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 8 THEN COALESCE( team_points.total,0) END) AS Aug'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 9 THEN COALESCE( team_points.total,0) END) AS Sep'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 10 THEN COALESCE( team_points.total,0) END) AS Oct'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 11 THEN COALESCE( team_points.total,0) END) AS Nov'),
            DB::raw('MAX(CASE WHEN COALESCE(MONTH(fixtures.date_time)) = 12 THEN COALESCE( team_points.total,0) END) AS Dece')
        )
        ->where('teams.is_approved', true)
        ->whereIn('teams.id', $teamIds)
        ->orderBy('teamName', 'desc')
        ->groupBy('teams.id', 'teams.name')
        ->get();
    }

    public function attachPlayedMatchesToFormGuide($positions)
    {
        foreach ($positions as $player) {
            $game = FixtureStats::select('player_id', DB::raw('COALESCE(COUNT(*), 0) as played'))
            ->where('appearance', '>', 0)
            ->where('player_id', $player->player_id)
            ->groupBy('player_id')
            ->groupBy('appearance')->first();
            $player->played = $game['played'];
        }
    }

    public function attachFreeAgentsData($freeAgents, $division)
    {
        $playerPositions = TeamPointsPositionEnum::toSelectArray();
        $freeAgents->each(function ($item, $key) use ($playerPositions, $packagePointCalculation) {
            $position = strtolower($playerPositions[$item->position]);
            $goals = ($division->getOptionValue($position, 'assist')) ? $item->total_goal : 0;
            $assist = $packagePointCalculation[$position]['assist'] ? $item->total_assist * $division->getOptionValue($position, 'assist') : $item->total_assist;
            $goalConceded = $packagePointCalculation[$position]['goal_conceded'] ? $item->total_goal_against * $packagePointCalculation[$position]['goal_conceded'] : $item->total_goal_against;
            $cleanSheet = $packagePointCalculation[$position]['clean_sheet'] ? $item->total_clean_sheet * $packagePointCalculation[$position]['clean_sheet'] : $item->total_clean_sheet;

            $item->total_assist = $assist;
            $item->total_clean_sheet = $cleanSheet;
            $item->total_goal = $goals;
            $item->total_goal_against = $goalConceded;
            $item->total = $goals + $assist + $goalConceded + $cleanSheet;
        });

        return $freeAgents;
    }
}
