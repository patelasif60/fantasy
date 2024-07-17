<?php

namespace App\Services;

use App\Enums\AuctionTypesEnum;
use App\Enums\TiePreferenceEnum;
use App\Models\AuctionTiePreference;
use App\Repositories\TiePreferenceRepository;

class TiePreferenceService
{
    /**
     * The TiePreference repository instance.
     *
     * @var TiePreferenceRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param TiePreferenceRepository $repository
     */
    public function __construct(TiePreferenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($tiePreference, $data)
    {
        $teamData = [];
        if ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED) {
            $teamData = $this->prepareTeam($data);
        }

        if ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES) {
            $tiePreferenceData = AuctionTiePreference::whereIn('team_id', $data)->orderBy('number', 'asc')->get();
            $count = count($tiePreferenceData);
            if ($count > 0) {
                foreach ($tiePreferenceData as $value) {
                    $teamData[$value->team_id] = $count;
                    $count--;
                }
            } else {
                $teamData = $this->prepareTeam($data);
            }
        }
        $this->repository->delete($data);

        return $this->repository->create($teamData);
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

    public function tieCreate($team)
    {
        $division = $team->teamDivision->first();

        if ($division && $division->auction_types === AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            $count = AuctionTiePreference::whereIn('team_id', $division->divisionTeams()->approve()->pluck('team_id'))->count();

            if ($count) {
                $tie = $team->tiePreferences()->create([
                    'number' => ($count + 1),
                ]);
            }
        }

        return true;
    }
}
