<?php

namespace App\Services;

use App\Enums\FixtureLineupPositionEnum;
use App\Enums\FixtureLineupTypesEnum;
use App\Repositories\FixtureFormationRepository;
use App\Repositories\FixtureLineupRepository;
use App\Repositories\PlayerContractRepository;
use Illuminate\Database\Eloquent\Collection;

class FixtureLineupService
{
    /**
     * The user repository instance.
     *
     * @var FixtureLineupRepository
     */
    protected $repository;

    /**
     * The user repository instance.
     *
     * @var PlayerContractRepository
     */
    protected $contractRepository;

    /**
     * The user repository instance.
     *
     * @var FixtureFormationRepository
     */
    protected $formationRepository;

    /**
     * Create a new service instance.
     *
     * @param FixtureLineupRepository $repository
     * @param PlayerContractRepository $contractRepository
     * @param FixtureFormationRepository $formationRepository
     */
    public function __construct(FixtureLineupRepository $repository, PlayerContractRepository $contractRepository, FixtureFormationRepository $formationRepository)
    {
        $this->repository = $repository;
        $this->contractRepository = $contractRepository;
        $this->formationRepository = $formationRepository;
    }

    public function getLineupData($fixture)
    {
        $lineupTypes = FixtureLineupTypesEnum::getValues();
        $lineupPositions = FixtureLineupPositionEnum::getValues();

        $formations = $this->formationRepository->getFormations()->pluck('name', 'id');
        $lineupsData = $this->repository->getLineupWithPlayers($fixture['id']);
        $homeClubPlayers = $this->contractRepository->getContractPlayers(['club_id' => $fixture['home_club_id']], $fixture['date_time']);

        $clubPlayers[$fixture['home_club_id']] = [];
        foreach ($homeClubPlayers as $player) {
            $clubPlayers[$fixture['home_club_id']][$player->player_id] = ['name' => $player->player->full_name.' '.substr($player->position, -5), 'position' => $player->position];
        }

        $awayClubPlayers = $this->contractRepository->getContractPlayers(['club_id' => $fixture['away_club_id']], $fixture['date_time']);
        $clubPlayers[$fixture['away_club_id']] = [];
        foreach ($awayClubPlayers as $player) {
            $clubPlayers[$fixture['away_club_id']][$player->player_id] = ['name' => $player->player->full_name.' '.substr($player->position, -5), 'position' => $player->position];
        }

        $lineups = new Collection;
        foreach ($lineupsData as $k => $lineup) {
            $lineups[$k] = new Collection;
            foreach ($lineup as $key => $value) {
                if ($value['club_id'] == $fixture['home_club_id']) {
                    $lineups[$k]['home'] = $value;
                } elseif ($value['club_id'] == $fixture['away_club_id']) {
                    $lineups[$k]['away'] = $value;
                }
            }
        }

        return compact(
            'lineupTypes',
            'lineupPositions',
            'formations',
            'lineups',
            'clubPlayers'
        );
    }

    public function store($data, $fixture_id)
    {
        return $this->repository->store($data, $fixture_id);
    }

    public function update($data, $fixture_id)
    {
        return $this->repository->update($data, $fixture_id);
    }

    public function getLineupWithPlayers($fixture_id)
    {
        return $this->repository->getLineupWithPlayers($fixture_id)->all();
    }
}
