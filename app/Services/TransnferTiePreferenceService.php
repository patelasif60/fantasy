<?php

namespace App\Services;

use App\Enums\TiePreferenceEnum;
use App\Models\TransferTiePreference;
use App\Repositories\TransferRoundRepository;
use App\Repositories\TransferTiePreferenceRepository;

class TransnferTiePreferenceService
{
    /**
     * The TransferTiePreference repository instance.
     *
     * @var TransferTiePreferenceRepository
     */
    protected $repository;

    protected $transferRoundRepository;

    public function __construct(TransferTiePreferenceRepository $repository, TransferRoundRepository $transferRoundRepository)
    {
        $this->repository = $repository;
        $this->transferRoundRepository = $transferRoundRepository;
    }

    public function create($tiePreference, $data, $round, $division = null)
    {
        $teamData = [];
        if ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED) {
            $teamData = $this->prepareTeam($data);
        }

        if ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES) {
            $endRound = null;
            if ($division) {
                $endRound = $this->transferRoundRepository->getEndedRound($division);
            }

            $count = 0;
            if ($endRound) {
                $tiePreferenceData = TransferTiePreference::whereIn('team_id', $data)
                                ->where('transfer_rounds_id', $endRound->id)
                                ->orderByRaw('cast(number as unsigned) asc')
                                ->get();
                $count = count($tiePreferenceData);
            }

            if ($count > 0) {
                foreach ($tiePreferenceData as $value) {
                    $teamData[$value->team_id] = $count;
                    $count--;
                }
            } else {
                $teamData = $this->prepareTeam($data);
            }
        }

        if ($tiePreference === TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS || $tiePreference === TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS) {
            if($tiePreference === TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS) {
                $allTeamData = $this->getTeamPoints($data)->sortBy('league_position');
            } else {
                $allTeamData = $this->getTeamPoints($data)->sortByDesc('league_position');
                
            }
            $count = count($allTeamData);
            if ($count > 0) {
                foreach ($allTeamData as $value) {
                    $teamData[$value['team_id']] = $count;
                    $count--;
                }
            } else {
                $teamData = $this->prepareTeam($data);
            }
        }

        $this->repository->delete($data, $round);
        
        return $this->repository->create($teamData, $round);
    }

    public function prepareTeam($data)
    {
        $teamData = [];
        $data = $data->shuffle();

        foreach ($data as $key => $value) {
            $teamData[$value] = $key + 1;
        }

        return $teamData;
    }

    public function getTransferTieNumber($division)
    {
        return $this->repository->getTransferTieNumber($division->divisionTeams()->approve()->get()->pluck('id'));
    }

    public function getTransferTieNumbers($division)
    {
        return $this->repository->getTransferTieNumbers($division->divisionTeams()->approve()->get()->pluck('id'));
    }

    public function delete($data, $round)
    {
        return $this->repository->delete($data, $round);
    }

    public function getTeamPoints($teams)
    {
        $teamPoints = $this->repository->getTeamPoints($teams);

        if(!$teamPoints->count()) {
            return collect();
        }

        $teamPoints = $teamPoints->toArray();

        array_multisort(array_column($teamPoints, 'total_points'), SORT_DESC,
                        array_column($teamPoints, 'total_goal'), SORT_DESC,
                        array_column($teamPoints, 'total_assist'), SORT_DESC,
                        $teamPoints);

        $position = 0;
        $temp = 0;
        foreach ($teamPoints as $key => $value) {
            $totalPoints = $value['total_points'];
            $totalGoal = $value['total_goal'];
            $totalAssist = $value['total_assist'];

            if ($key > 0) {
                if ($totalPoints == $teamPoints[$key - 1]['total_points'] && $totalGoal == $teamPoints[$key - 1]['total_goal'] && $totalAssist == $teamPoints[$key - 1]['total_assist']) {
                    $temp++;
                } else {
                    $position++;
                    $position = $position + $temp;
                    $temp = 0;
                }
            } else {
                $position++;
                $position = $position + $temp;
                $temp = 0;
            }
            $teamPoints[$key]['league_position'] = $position;
        }

        return collect($teamPoints);
    }
}