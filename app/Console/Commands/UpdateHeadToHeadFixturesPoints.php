<?php

namespace App\Console\Commands;

use App\Enums\HeadToHeadFixturesOutcomeEnum;
use App\Enums\HeadToHeadFixturesStatusEnum;
use App\Services\DivisionService;
use App\Services\GameWeekService;
use App\Services\HeadToHeadFixtureService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateHeadToHeadFixturesPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'head-to-head-fixtures:update {--all} {--D|date= : Date for which fixtures needs to be updated. Format (YYYY-mm-dd)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update head to head fixtures points in table';

    protected $winnerPoints = 3;

    protected $drawPoints = 1;

    protected $looserPoints = 0;

    /**
     * The GameWeekService instance.
     *
     * @var GameWeekService
     */
    protected $gameWeekService;

    /**
     * The DivisionService instance.
     *
     * @var DivisionService
     */
    protected $divisionService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GameWeekService $gameWeekService, DivisionService $divisionService, HeadToHeadFixtureService $headToHeadFixtureService)
    {
        $this->gameWeekService = $gameWeekService;
        $this->divisionService = $divisionService;
        $this->headToHeadFixtureService = $headToHeadFixtureService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        info('Start update head to head fixtures...');
        $this->info('Start update head to head fixtures...');
        $date = now();

        if ($this->option('all')) {
            $gameweeks = $this->gameWeekService->getPreviousGameWeeksFromDate($date);
        } elseif ($this->option('date')) {
            try {
                $date = Carbon::parse($this->option('date'));
            } catch (\Exception $e) {
                echo "Invalid date, please pass Y-m-d date.\n";

                return;
            }
            $gameweeks = $this->gameWeekService->getPreviousGameWeeksFromDate($date, 1);
        } else {
            $gameweeks = $this->gameWeekService->getPreviousGameWeeksFromDate($date, 1);
        }

        if (! $gameweeks) {
            info('gameweeks not found.');
            $this->info('gameweeks not found.');

            return;
        }

        foreach ($gameweeks as $gameweek) {
            $fixtures = $this->headToHeadFixtureService->getFixturesFromGameWeek($gameweek);

            foreach ($fixtures as $fixture) {
                $home_team_id = $fixture->home_team_id;
                $away_team_id = $fixture->away_team_id;

                $filter['teams'] = [$home_team_id, $away_team_id];
                $filter['startDate'] = $gameweek->start;
                $filter['endDate'] = $gameweek->end;

                $teams = $this->divisionService->getTeamsScores($filter);

                if (! $teams) {
                    continue;
                }

                $home = $teams->where('teamId', $home_team_id)->first();
                $away = $teams->where('teamId', $away_team_id)->first();

                if ($away && $home) {
                    if ($home->total_point > $away->total_point) {
                        $home_team_head_to_head_points = $this->winnerPoints;
                        $away_team_head_to_head_points = $this->looserPoints;
                        $winner = $home->teamId;
                        $outcome = HeadToHeadFixturesOutcomeEnum::H;
                    } elseif ($home->total_point < $away->total_point) {
                        $home_team_head_to_head_points = $this->looserPoints;
                        $away_team_head_to_head_points = $this->winnerPoints;
                        $winner = $away->teamId;
                        $outcome = HeadToHeadFixturesOutcomeEnum::A;
                    } else {
                        $home_team_head_to_head_points = $this->drawPoints;
                        $away_team_head_to_head_points = $this->drawPoints;
                        $winner = null;
                        $outcome = HeadToHeadFixturesOutcomeEnum::D;
                    }

                    $data = [
                        'status' => HeadToHeadFixturesStatusEnum::PLAYED,
                        'outcome' => $outcome,
                        'home_team_points' => $home->total_point,
                        'away_team_points' => $away->total_point,
                        'home_team_head_to_head_points' => $home_team_head_to_head_points,
                        'away_team_head_to_head_points' => $away_team_head_to_head_points,
                        'winner_id' => $winner,
                    ];

                    $this->headToHeadFixtureService->update($fixture, $data);

                    $this->info('Updated fixture id: '.$fixture->id);
                } else {
                    info('Not updated fixture id: '.$fixture->id);
                    $this->info('Not updated fixture id: '.$fixture->id);
                }
            }
        }
        info('End update head to head fixtures.');
        $this->info('End update head to head fixtures.');
    }
}
