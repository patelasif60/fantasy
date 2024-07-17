<?php

namespace App\Repositories;

use Response;
use Mpdf\Mpdf;
use App\Models\Club;
use App\Models\Player;
use App\Models\Season;
use App\Models\GameWeek;
use App\Enums\EventsEnum;
use Illuminate\Support\Arr;
use App\Enums\PositionsEnum;
use App\Models\HistoryStats;
use App\Exports\PlayersExport;
use App\Enums\TransferTypeEnum;
use App\Models\TeamPlayerPoint;
use App\Enums\CompetitionEnum;
use App\Services\PlayerService;
use App\Services\DivisionService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PlayerContractPosition\MergeDefenderDefensiveMidfielderEnum;

class PlayerRepository
{
    public function create($data)
    {
        return Player::create([
            'first_name' => Arr::has($data, 'first_name') ? $data['first_name'] : '',
            'last_name' => $data['last_name'],
            'api_id' => $data['api_id'],
            'short_code' => $data['short_code'],
        ]);
    }

    public function update($player, $data)
    {
        $player->fill([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'api_id' => $data['api_id'],
            'short_code' => $data['short_code'],
        ]);

        $player->save();

        return $player;
    }

    public function getClubs()
    {
        return Club::pluck('name', 'id')->all();
    }

    public function playerImageDestroy($player)
    {
        return $player->clearMediaCollection('player_image');
    }

    public function getAllPlayers()
    {
        $seasonRepository = app(SeasonRepository::class);
        $season = $seasonRepository->getLatestEndSeason();

        $players = Player::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) use ($season) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id', function ($query) use ($season) {
                $query->select('id')
                    ->from('fixtures')
                    ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
                    ->where('season_id', $season->id);
            });
        })->leftJoin('fixtures', function ($join) {
            $join->on('fixtures.id', '=', 'fixture_stats_for_stats.fixture_id');
        })->join('player_contracts', 'player_contracts.player_id', '=', 'players.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->selectRaw('players.short_code,players.id,players.first_name as player_first_name, players.last_name as player_last_name,clubs.short_code as club_name,player_contracts.position,
                SUM(fixture_stats_for_stats.goal) as total_goal,
                SUM(fixture_stats_for_stats.assist) as total_assist,
                SUM(fixture_stats_for_stats.goal_conceded) as total_goal_against,
                SUM(fixture_stats_for_stats.clean_sheet) as total_clean_sheet,
                SUM(IF(fixture_stats_for_stats.appearance >= 45 , 1, 0)) as total_game_played,
                SUM(fixture_stats_for_stats.own_goal) as total_own_goal,
                SUM(fixture_stats_for_stats.red_card) as total_red_card,
                SUM(fixture_stats_for_stats.yellow_card) as total_yellow_card,
                SUM(fixture_stats_for_stats.penalty_missed) as total_penalty_missed,
                SUM(fixture_stats_for_stats.penalty_save) as total_penalty_saved,
                SUM(fixture_stats_for_stats.goalkeeper_save DIV 5) as total_goalkeeper_save,
                SUM(fixture_stats_for_stats.club_win) as total_club_win')
            ->where('player_contracts.is_active', true)
            ->whereNull('player_contracts.end_date')
            ->where('clubs.is_premier', true)
            ->groupBy('players.id', 'clubs.id', 'player_contracts.position', 'clubs.short_code')
            ->orderBy('clubs.short_code')
            ->get();

        return $players;
    }

    public function getAllPlayersWithPointsCalculation($division)
    {
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);
        $players = $this->getAllPlayers($division);
        $collection = collect($players)->map(function ($data) use ($divisionPoints, $division) {
            $goal = isset($divisionPoints[$data->position][EventsEnum::GOAL]) && $divisionPoints[$data->position][EventsEnum::GOAL] ? $divisionPoints[$data->position][EventsEnum::GOAL] : 0;
            $assist = isset($divisionPoints[$data->position][EventsEnum::ASSIST]) && $divisionPoints[$data->position][EventsEnum::ASSIST] ? $divisionPoints[$data->position][EventsEnum::ASSIST] : 0;
            $goalConceded = isset($divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] : 0;
            $cleanSheet = isset($divisionPoints[$data->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] : 0;
            $appearance = isset($divisionPoints[$data->position][EventsEnum::APPEARANCE]) && $divisionPoints[$data->position][EventsEnum::APPEARANCE] ? $divisionPoints[$data->position][EventsEnum::APPEARANCE] : 0;
            $clubWin = isset($divisionPoints[$data->position][EventsEnum::CLUB_WIN]) && $divisionPoints[$data->position][EventsEnum::CLUB_WIN] ? $divisionPoints[$data->position][EventsEnum::CLUB_WIN] : 0;
            $redCard = isset($divisionPoints[$data->position][EventsEnum::RED_CARD]) && $divisionPoints[$data->position][EventsEnum::RED_CARD] ? $divisionPoints[$data->position][EventsEnum::RED_CARD] : 0;
            $yellowCard = isset($divisionPoints[$data->position][EventsEnum::YELLOW_CARD]) && $divisionPoints[$data->position][EventsEnum::YELLOW_CARD] ? $divisionPoints[$data->position][EventsEnum::YELLOW_CARD] : 0;
            $ownGoal = isset($divisionPoints[$data->position][EventsEnum::OWN_GOAL]) && $divisionPoints[$data->position][EventsEnum::OWN_GOAL] ? $divisionPoints[$data->position][EventsEnum::OWN_GOAL] : 0;
            $penaltyMissed = isset($divisionPoints[$data->position][EventsEnum::PENALTY_MISSED]) && $divisionPoints[$data->position][EventsEnum::PENALTY_MISSED] ? $divisionPoints[$data->position][EventsEnum::PENALTY_MISSED] : 0;
            $penaltySave = isset($divisionPoints[$data->position][EventsEnum::PENALTY_SAVE]) && $divisionPoints[$data->position][EventsEnum::PENALTY_SAVE] ? $divisionPoints[$data->position][EventsEnum::PENALTY_SAVE] : 0;
            $goalkeeperSave = isset($divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5]) && $divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5] ? $divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5] : 0;

            $total = 0;
            $total += $goal * $data->total_goal;
            $total += $assist * $data->total_assist;
            $total += $goalConceded * $data->total_goal_against;
            $total += $cleanSheet * $data->total_clean_sheet;
            $total += $appearance * $data->total_game_played;
            $total += $clubWin * $data->total_club_win;
            $total += $yellowCard * $data->total_yellow_card;
            $total += $redCard * $data->total_red_card;
            $total += $ownGoal * $data->total_own_goal;
            $total += $penaltyMissed * $data->total_penalty_missed;
            $total += $penaltySave * $data->total_penalty_saved;
            $total += $goalkeeperSave * $data->total_goalkeeper_save;

            $data->total = $total;

            $data->position = $division->getPositionFullCode($data->position);

            return $data;
        });

        return $collection;
    }

    public function exporttopdf($division, $forApi = false)
    {
        $date = now()->format('D, d M');
        $name = 'Player List - '.config('app.name');
        $data = $this->getAllPlayersWithPointsCalculation($division);
        $positions = $this->getAllPositions($division);

        $mpdf = new Mpdf();
        $mpdf->defaultfooterfontsize = 8;
        $mpdf->defaultheaderline = 0;
        $mpdf->defaultfooterline = 0;
        $mpdf->SetHeader(''.$date.'||'.$name.'');
        $mpdf->SetFooter('|{PAGENO}|');
        $mpdf->WriteHTML('<columns column-count="3" vAlign="J" column-gap="7" />');

        $i = 0;
        foreach ($positions as $positionKey => $position) {
            if ($data->where('position', $positionKey)->count()) {
                $positionFullName = strtoupper(player_position_except_code($positionKey)).'S';

                $mpdf->WriteHTML('<table width="100%" style="font-size: 10px; font-family: sans-serif;">');
                $mpdf->WriteHTML('<thead><tr><td></td><td colspan="3" style="font-weight: bold;padding-bottom:5px;">'.$positionFullName.'</td></tr><tr><td style="font-weight: bold;">Code</td><td style="font-weight: bold;">Name</td><td style="font-weight: bold;">Club</td><td style="font-weight: bold;">Pts</td></tr></thead>');

                foreach ($data->where('position', $positionKey) as $player) {
                    $mpdf->WriteHTML('<tr>');
                    $mpdf->WriteHTML('<td>'.$player->short_code.'</td><td>'.get_player_name('firstNameFirstCharAndFullLastName', $player->player_first_name, $player->player_last_name).'</td><td>'.$player->club_name.'</td><td>'.$player->total.'</td>');
                    $mpdf->WriteHTML('</tr>');
                }

                $mpdf->WriteHTML('<tr>');
                $mpdf->WriteHTML('<td colspan="4">&nbsp;</td>');
                $mpdf->WriteHTML('</tr>');

                $mpdf->WriteHTML('</table>');
                $i++;
            }
        }

        if (! $forApi) {
            $mpdf->Output(storage_path($name.'.pdf'));
            $headers = ['Content-Type: application/pdf'];

            return Response::download(storage_path($name.'.pdf'), ''.$name.'.pdf', $headers)->deleteFileAfterSend(true);
        } else {

            $printable = public_path('printable');
            $this->createFolder($printable);
            $mpdf->Output($printable.'/'.$name.'.pdf', 'F');

            return add_slash_in_url_end(config('app.url')).'printable/'.$name.'.pdf';
        }
    }

    public function getAllPositions($division)
    {
        $playerService = app(PlayerService::class);

        return $playerService->getAllPositions($division);
    }

    public function exporttoexcel($division, $forApi = false)
    {
        $name = 'Player List - '.config('app.name');
        $positions = $this->getAllPositions($division);
        $data = $this->getAllPlayersWithPointsCalculation($division);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $Excel_writer = new Xls($spreadsheet);

        $spreadsheet->getProperties()
            ->setCreator(config('app.name'))
            ->setLastModifiedBy(config('app.name'))
            ->setTitle($name);

        $sheet->getPageSetup()->setFitToHeight(0);

        //Updated Date
        $sheet->setCellValue('B1', 'LAST UPDATED:');
        $sheet->setCellValue('C1', now()->format('D, d M'));
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Calibri',
            ],
        ]);

        $cellAlpha = 0;
        $cellNumber = 2;

        $perRowRecord = 85;
        $rowRecord = 0;

        $perColumnRecord = 2;
        $columnRecord = 0;
        $page = 2;
        $header = true;
        foreach ($positions as $positionKey => $position) {
            $positionFullName = strtoupper(player_position_except_code($positionKey)).'S';

            $sheet = $this->setPlayerExecelPosition($sheet, $cellAlpha, $cellNumber, $positionFullName);
            $cellNumber++;

            if ($page == 2 && $header) {
                $sheet = $this->setPlayerExecelHeader($sheet, $cellAlpha, $cellNumber);
                $cellNumber++;
                $header = false;
            }

            if ($data->where('position', $positionKey)->count()) {
                foreach ($data->where('position', $positionKey) as $player) {
                    $sheet = $this->setPlayerExecelBody($sheet, $cellAlpha, $cellNumber, $player);

                    $cellNumber++;
                    $rowRecord++;

                    if ($rowRecord > $perRowRecord) {
                        $rowRecord = 0;
                        $cellAlpha = $cellAlpha + 5;
                        $cellNumber = $page;
                        $columnRecord++;

                        $sheet = $this->setPlayerExecelPosition($sheet, $cellAlpha, $cellNumber, $positionFullName.' (cont.)');
                        $cellNumber++;

                        if ($page == 2) {
                            $sheet = $this->setPlayerExecelHeader($sheet, $cellAlpha, $cellNumber);
                            $cellNumber++;
                        }
                    }

                    if ($columnRecord >= $perColumnRecord && $rowRecord >= $perRowRecord) {
                        $rowRecord = 0;
                        $columnRecord = 0;
                        $cellNumber = $cellNumber + 3;
                        $page = $cellNumber;
                        $cellAlpha = 0;

                        $sheet = $this->setPlayerExecelPosition($sheet, $cellAlpha, $cellNumber, $positionFullName.' (cont.)');
                        $cellNumber++;
                    }
                }
            }
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');

        if (! $forApi) {
            $Excel_writer->save('php://output');
        } else {

            $printable = public_path('printable');
            $this->createFolder($printable);
            $Excel_writer->save($printable.'/'.$name.'.xls');

            return add_slash_in_url_end(config('app.url')).'printable/'.$name.'.xls';
        }
    }

    public function createFolder($path) {

        if(!Storage::exists($path)) {

            \File::makeDirectory($path, 0777, true, true);
        }
    }

    public function setPlayerExecelHeader($sheet, $cellAlpha, $cellNumber)
    {
        $sheet->setCellValueByColumnAndRow($cellAlpha + 1, $cellNumber, 'Code');
        $sheet->setCellValueByColumnAndRow($cellAlpha + 2, $cellNumber, 'Name');
        $sheet->setCellValueByColumnAndRow($cellAlpha + 3, $cellNumber, 'Club');
        $sheet->setCellValueByColumnAndRow($cellAlpha + 4, $cellNumber, 'Pts');

        $sheet->getStyle($this->num2alpha($cellAlpha, $cellNumber).':'.$this->num2alpha($cellAlpha + 3, $cellNumber))->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Calibri',
            ],
        ]);

        return $sheet;
    }

    public function setPlayerExecelBody($sheet, $cellAlpha, $cellNumber, $player)
    {
        $sheet->setCellValueByColumnAndRow($cellAlpha + 1, $cellNumber, $player->short_code);
        $sheet->setCellValueByColumnAndRow($cellAlpha + 2, $cellNumber, get_player_name('firstNameFirstCharAndFullLastName', $player->player_first_name, $player->player_last_name));
        $sheet->setCellValueByColumnAndRow($cellAlpha + 3, $cellNumber, $player->club_name);
        $sheet->setCellValueByColumnAndRow($cellAlpha + 4, $cellNumber, $player->total);

        $sheet->getStyle($this->num2alpha($cellAlpha, $cellNumber).':'.$this->num2alpha($cellAlpha + 3, $cellNumber))->applyFromArray([
            'font' => [
                'size' => 10,
                'name' => 'Calibri',
            ],
        ]);

        return $sheet;
    }

    public function setPlayerExecelPosition($sheet, $cellAlpha, $cellNumber, $positionFullName)
    {
        $sheet->setCellValueByColumnAndRow($cellAlpha + 2, $cellNumber, $positionFullName);
        $sheet->getStyle($this->num2alpha($cellAlpha + 1, $cellNumber))->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Calibri',
            ],
        ]);

        return $sheet;
    }

    public function num2alpha($n, $n1)
    {
        for ($r = ''; $n >= 0; $n = intval($n / 26) - 1) {
            $r = chr($n % 26 + 0x41).$r;
        }

        return $r.$n1;
    }

    public function playerWeekPoints($player_id)
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        $gameweeks = GameWeek::where('start', '<=', $date)->where('season_id', Season::getLatestSeason());
        if ($gameweeks) {
            $gameweeks = $gameweeks->limit(1);
        }
        $gameweek = $gameweeks->orderBy('start', 'desc')->first();

        $playerStats = TeamPlayerPoint::join('team_points', 'team_points.id', '=', 'team_player_points.team_point_id')
                        ->join('fixtures', function ($query) use ($gameweek) {
                            $query->on('fixtures.id', '=', 'team_points.fixture_id')
                                ->whereBetween('fixtures.date_time', [$gameweek->start, $gameweek->end])
                                ->where('season_id', Season::getLatestSeason());
                        })
                        ->selectRaw('
                            team_player_points.player_id,
                            SUM(team_player_points.total) as total
                        ')
                        ->where('team_player_points.player_id', $player_id)
                        ->groupBy('team_player_points.player_id')
                        ->get();

        if (isset($playerStats[0])) {
            return $playerStats[0]->total;
        } else {
            return 0;
        }
    }

    public function playerNextFixture($club_id)
    {
        $nextFixture = Club::find($club_id)->nextFixture();
        if (isset($nextFixture)) {
            $playerClubId = $club_id;
            if ($playerClubId == $nextFixture->home_club_id) {
                $fixture['type'] = 'H';
                $fixture['short_code'] = $nextFixture->away_team->short_code;
            } else {
                $fixture['type'] = 'A';
                $fixture['short_code'] = $nextFixture->home_team->short_code;
            }
            $fixture['date_time'] = $nextFixture->date_time;
            $fixture['time'] = carbon_format_to_time_for_fixture($nextFixture->date_time);
            $fixture['str_date'] = carbon_format_to_date_for_fixture_format1($nextFixture->date_time);
            $nextFixture = $fixture;
        }

        return $nextFixture;
    }

    public function getPlayerScoresDivisionDateWise($division, $data)
    {
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $currentSeason = Season::find(Season::getLatestSeason());
        $season = $currentSeason->firstFixturePlayed() ? $currentSeason : Season::find(Season::getPreviousSeason());

        $players = Player::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) use ($season, $startDate, $endDate) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id',
                            function ($query) use ($season, $startDate, $endDate) {
                                $query->select('id')
                                ->from('fixtures')
                                ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
                                ->where('fixtures.date_time', '>=', $startDate)
                                ->where('fixtures.date_time', '<', $endDate)
                                ->where('season_id', $season->id);
                            });
        })
                ->leftJoin('fixtures', function ($join) {
                    $join->on('fixtures.id', '=', 'fixture_stats_for_stats.fixture_id');
                })
                ->join('player_contracts', 'player_contracts.player_id', '=', 'players.id')
                ->leftJoin('player_status', function ($join) {
                    $join->on('player_status.player_id', '=', 'players.id')
                        ->where(function ($query) {
                            $query->whereNull('player_status.end_date')
                            ->orWhereDate('player_status.end_date', '>=', now()->toDateString());
                        });
                })
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw("team_player_contracts INNER JOIN teams ON teams.id = team_player_contracts.team_id AND team_player_contracts.end_date IS NULL INNER JOIN transfers
                    ON transfers.id = (SELECT id FROM transfers WHERE transfers.player_in = team_player_contracts.player_id AND teams.id = transfers.team_id AND transfers.transfer_type = '".TransferTypeEnum::AUCTION."' ORDER BY transfers.transfer_date DESC LIMIT 1) INNER JOIN division_teams ON division_teams.team_id = teams.id  AND division_teams.division_id = '".$division->id."'"),
                  function ($join) {
                      $join->on('team_player_contracts.player_id', '=', 'players.id');
                  })
                ->leftJoin('consumers', 'consumers.id', '=', 'teams.manager_id')
                ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
                ->selectRaw('players.id,player_contracts.position,
                    SUM(fixture_stats_for_stats.goal) as total_goal,
                    SUM(fixture_stats_for_stats.assist) as total_assist,
                    SUM(fixture_stats_for_stats.goal_conceded) as total_goal_against,
                    SUM(fixture_stats_for_stats.clean_sheet) as total_clean_sheet,
                    SUM(IF(fixture_stats_for_stats.appearance >= 45 , 1, 0)) as total_game_played,
                    SUM(fixture_stats_for_stats.own_goal) as total_own_goal,
                    SUM(fixture_stats_for_stats.red_card) as total_red_card,
                    SUM(fixture_stats_for_stats.yellow_card) as total_yellow_card,
                    SUM(fixture_stats_for_stats.penalty_missed) as total_penalty_missed,
                    SUM(fixture_stats_for_stats.penalty_save) as total_penalty_saved,
                    SUM(fixture_stats_for_stats.goalkeeper_save DIV 5) as total_goalkeeper_save,
                    SUM(fixture_stats_for_stats.club_win) as total_club_win')
                ->where('player_contracts.is_active', true)
                ->whereNull('player_contracts.end_date')
                ->where('clubs.is_premier', true);

        if (Arr::has($data, 'position')) {
            $position = $data['position'];

            if ($position == AllPositionEnum::DEFENDER) {
                $players = $players->where(function ($query) {
                    $query->orwhere('player_contracts.position', AllPositionEnum::CENTREBACK)
                                              ->orWhere('player_contracts.position', AllPositionEnum::FULLBACK);
                });
            } elseif ($position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                $players = $players->where('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
            } elseif ($position == AllPositionEnum::MIDFIELDER) {
                if ($division->getOptionValue('defensive_midfields') != 'Yes') {
                    $players = $players->where(function ($query) {
                        $query->orwhere('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
                                              ->orWhere('player_contracts.position', AllPositionEnum::MIDFIELDER);
                    });
                } else {
                    $players = $players->where('player_contracts.position', AllPositionEnum::MIDFIELDER);
                }
            } else {
                $players = $players->where('player_contracts.position', $position);
            }
        }
        if (Arr::has($data, 'club')) {
            $players = $players->where('clubs.id', $data['club']);
        }

        return $players->groupBy('players.id', 'clubs.id', 'clubs.name', 'player_status.status', 'player_status.description', 'player_contracts.position', 'teams.id', 'teams.name', 'transfers.transfer_value', 'clubs.short_code', 'team_player_contracts.id')->get();
    }

    public function playerInitialCount($names)
    {
        $count = Player::whereIn('last_name', $names)
        ->select('last_name', \DB::raw('count(*) as total'))
        ->groupBy('last_name')
        ->get()->pluck('total', 'last_name');

        return $count;
    }

    public function historyData($plaerID)
    {
        $count = HistoryStats::where('history_stats.player_id', $plaerID)
        ->selectRaw('*,(select player_contracts.`position` from `player_contracts` where `player_contracts`.`player_id` = `history_stats`.`player_id` and end_date is null ) as position')
        ->orderBy('history_stats.season_id', 'desc')
        ->get();

        return $count;
    }

    public function getPlayerDetails($player_id)
    {
        $details = Player::find($player_id);

        $s3Url = config('fantasy.aws_url').'/tshirts/';

        $player['id'] = $details->id;
        $player['first_name'] = $details->first_name;
        $player['last_name'] = $details->last_name;
        $player['club'] = $details->playerContract->club->name;
        $player['club_short_name'] = $details->playerContract->club->short_code;
        $player['position'] = player_position_short($details->playerContract->position);

        if ($player['position'] == 'GK') {
            $player['tshirt'] = $s3Url.$player['club'].'/GK.png';
        } else {
            $player['tshirt'] = $s3Url.$player['club'].'/player.png';
        }

        if ($details->playerStatus !== null) {
            $player['status']['status'] = $details->playerStatus->status;
            $player['status']['end_date'] = carbon_format_to_date($details->playerStatus->end_date);
            $player['status']['description'] = $details->playerStatus->description;
            $player['status']['image'] = '/assets/frontend/img/status/'.strtolower(implode('', explode(' ', $details->playerStatus->status))).'.svg';
        }

        $player['image'] = $details->getPlayerCrest();
        
        return $player;
    }
}
