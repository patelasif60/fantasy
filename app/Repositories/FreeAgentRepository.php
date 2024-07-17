<?php

namespace App\Repositories;

use Response;
use Mpdf\Mpdf;
use App\Models\Player;
use App\Models\Season;
use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Enums\CompetitionEnum;
use App\Enums\TransferTypeEnum;
use App\Services\DivisionService;
use App\Models\TeamPlayerContract;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class FreeAgentRepository
{
    public function getAllPlayers($division)
    {
        $currentSeason = Season::find(Season::getLatestSeason());

        $season = $currentSeason->firstFixturePlayed() ? $currentSeason : Season::find(Season::getPreviousSeason());
        $teamIds = $division->divisionTeams->pluck('id');
        $playersId = TeamPlayerContract::whereIn('team_id', $teamIds)->whereNull('team_player_contracts.end_date')->pluck('player_id');

        $players = Player::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) use ($season) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id',
                    function ($query) use ($season) {
                                $query->select('id')
                                ->from('fixtures')
                                ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
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
                ->selectRaw('players.id,players.first_name as player_first_name,players.last_name as player_last_name,clubs.id as club_id,clubs.short_code as club_name,player_status.status as player_status,player_contracts.position,teams.id as team_id,teams.name as team_name,transfers.transfer_value as bid,clubs.short_code,team_player_contracts.id as team_player_contract_id,
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
                ->whereNotIn('players.id', $playersId);

        $players = $players->groupBy('players.id', 'clubs.id', 'clubs.name', 'player_status.status', 'player_contracts.position', 'teams.id', 'teams.name', 'transfers.transfer_value', 'clubs.short_code', 'team_player_contracts.id')->orderBy('clubs.name')->get();

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

    public function getAllPositions($division)
    {
        $positions = ($division->playerPositionEnum())::toSelectArray();

        return $positions;
    }

     public function exporttopdf($division, $forApi = false)
    {
        $date = now()->format('D, d M');
        $name = 'Free Agents List - '.config('app.name');
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
                $mpdf->WriteHTML('<thead><tr><td></td><td colspan="3" style="font-weight: bold;padding-bottom:5px;">'.$positionFullName.'</td></tr><tr><td style="font-weight: bold;">Name</td><td style="font-weight: bold;">Club</td><td style="font-weight: bold;">Pld</td><td style="font-weight: bold;">Pts</td></tr></thead>');

                foreach ($data->where('position', $positionKey) as $player) {
                    $mpdf->WriteHTML('<tr>');
                    $mpdf->WriteHTML('<td>'.get_player_name('firstNameFirstCharAndFullLastName', $player->player_first_name, $player->player_last_name).'</td><td>'.$player->club_name.'</td><td>'.$player->total_game_played.'</td><td>'.$player->total.'</td>');
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

    public function exporttoexcel($division, $forApi = false)
    {
        $name = 'Free Agents List - '.config('app.name');
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
        $sheet->setCellValueByColumnAndRow($cellAlpha + 1, $cellNumber, 'Name');
        $sheet->setCellValueByColumnAndRow($cellAlpha + 2, $cellNumber, 'Club');
        $sheet->setCellValueByColumnAndRow($cellAlpha + 3, $cellNumber, 'Pld');
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
        $sheet->setCellValueByColumnAndRow($cellAlpha + 1, $cellNumber, get_player_name('firstNameFirstCharAndFullLastName', $player->player_first_name, $player->player_last_name));
        $sheet->setCellValueByColumnAndRow($cellAlpha + 2, $cellNumber, $player->club_name);
        $sheet->setCellValueByColumnAndRow($cellAlpha + 3, $cellNumber, $player->total_game_played);
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
}
