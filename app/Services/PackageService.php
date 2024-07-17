<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Repositories\PackageRepository;

class PackageService
{
    const DEFENSIVE_MID_FIELDER = 'defensive_mid_fielder';
    const MID_FIELDER = 'mid_fielder';
    const CENTRE_BACK = 'centre_back';
    const FULL_BACK = 'full_back';

    /**
     * The package repository instance.
     *
     * @var PackageRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param PackageRepository $packageRepository
     */
    public function __construct(PackageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($package)
    {
        return $this->repository->create($package);
    }

    public function update($package, $data)
    {
        return $this->repository->update($package, $data);
    }

    public function list()
    {
        return $this->repository->list();
    }

    public function getPackagePoints($package, $positionsEnums)
    {
        $pointCalc = [];
        foreach ($positionsEnums as $positionsEnumKey => $positionsEnum) {
            $playerPosition = player_position_full($positionsEnum);

            if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
                $playerPosition = ($package->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
            }

            if ($playerPosition == self::CENTRE_BACK) {
                $playerPosition = ($package->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
            }

            $playerPosShort = player_position_short($playerPosition);

            $pointCalc[$playerPosShort][EventsEnum::GOAL] = $package->getOptionValue($positionsEnumKey, EventsEnum::GOAL);
            $pointCalc[$playerPosShort][EventsEnum::ASSIST] = $package->getOptionValue($positionsEnumKey, EventsEnum::ASSIST);
            $pointCalc[$playerPosShort][EventsEnum::CLEAN_SHEET] = $package->getOptionValue($positionsEnumKey, EventsEnum::CLEAN_SHEET);
            $pointCalc[$playerPosShort][EventsEnum::GOAL_CONCEDED] = $package->getOptionValue($positionsEnumKey, EventsEnum::GOAL_CONCEDED);
            $pointCalc[$playerPosShort][EventsEnum::APPEARANCE] = $package->getOptionValue($positionsEnumKey, EventsEnum::APPEARANCE);
            $pointCalc[$playerPosShort][EventsEnum::CLUB_WIN] = $package->getOptionValue($positionsEnumKey, EventsEnum::CLUB_WIN);
            $pointCalc[$playerPosShort][EventsEnum::YELLOW_CARD] = $package->getOptionValue($positionsEnumKey, EventsEnum::YELLOW_CARD);
            $pointCalc[$playerPosShort][EventsEnum::RED_CARD] = $package->getOptionValue($positionsEnumKey, EventsEnum::RED_CARD);
            $pointCalc[$playerPosShort][EventsEnum::OWN_GOAL] = $package->getOptionValue($positionsEnumKey, EventsEnum::OWN_GOAL);
            $pointCalc[$playerPosShort][EventsEnum::PENALTY_MISSED] = $package->getOptionValue($positionsEnumKey, EventsEnum::PENALTY_MISSED);
            $pointCalc[$playerPosShort][EventsEnum::PENALTY_SAVE] = $package->getOptionValue($positionsEnumKey, EventsEnum::PENALTY_SAVE);
            $pointCalc[$playerPosShort][EventsEnum::GOALKEEPER_SAVE_X5] = $package->getOptionValue($positionsEnumKey, EventsEnum::GOALKEEPER_SAVE_X5);
        }

        return $pointCalc;
    }
}
