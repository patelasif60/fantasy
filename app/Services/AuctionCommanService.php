<?php

namespace App\Services;

use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\YesNoEnum;

class AuctionCommanService
{
    /**
     * The Auction Service instance.
     *
     * @var AuctionService
     */
    protected $auctionService;

    public function __construct(AuctionService $auctionService)
    {
        $this->auctionService = $auctionService;
    }

    public function getPositions($division)
    {
        return $positions = $this->auctionService->getPositions($division);
    }

    public function setPlayerPositions($division, $data)
    {
        if (! $data->has(AllPositionEnum::GOALKEEPER)) {
            $data->put(AllPositionEnum::GOALKEEPER, collect());
        }
        if (! $data->has(AllPositionEnum::CENTREBACK)) {
            $data->put(AllPositionEnum::CENTREBACK, collect());
        }
        if (! $data->has(AllPositionEnum::FULLBACK)) {
            $data->put(AllPositionEnum::FULLBACK, collect());
        }
        if ($division->getOptionValue('merge_defenders') == YesNoEnum::YES) {
            $data[AllPositionEnum::DEFENDER] = $data[AllPositionEnum::FULLBACK]->concat($data[AllPositionEnum::CENTREBACK]);
            $data->forget(AllPositionEnum::FULLBACK);
            $data->forget(AllPositionEnum::CENTREBACK);
        }
        if (! $data->has(AllPositionEnum::MIDFIELDER)) {
            $data->put(AllPositionEnum::MIDFIELDER, collect());
        }
        if (! $data->has(AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
            $data->put(AllPositionEnum::DEFENSIVE_MIDFIELDER, collect());
        }
        if ($division->getOptionValue('defensive_midfields') == YesNoEnum::NO) {
            $data[AllPositionEnum::MIDFIELDER] = $data[AllPositionEnum::MIDFIELDER]->concat($data[AllPositionEnum::DEFENSIVE_MIDFIELDER]);
            $data->forget(AllPositionEnum::DEFENSIVE_MIDFIELDER);
        }
        if (! $data->has(AllPositionEnum::STRIKER)) {
            $data->put(AllPositionEnum::STRIKER, collect());
        }
        $tempTeamPlayers[AllPositionEnum::GOALKEEPER] = $data[AllPositionEnum::GOALKEEPER];
        if ($division->getOptionValue('merge_defenders') == YesNoEnum::YES) {
            $tempTeamPlayers[AllPositionEnum::DEFENDER] = $data[AllPositionEnum::DEFENDER];
        } else {
            $tempTeamPlayers[AllPositionEnum::FULLBACK] = $data[AllPositionEnum::FULLBACK];
            $tempTeamPlayers[AllPositionEnum::CENTREBACK] = $data[AllPositionEnum::CENTREBACK];
        }
        if ($division->getOptionValue('defensive_midfields') == YesNoEnum::YES) {
            $tempTeamPlayers[AllPositionEnum::DEFENSIVE_MIDFIELDER] = $data[AllPositionEnum::DEFENSIVE_MIDFIELDER];
        }
        $tempTeamPlayers[AllPositionEnum::MIDFIELDER] = $data[AllPositionEnum::MIDFIELDER];
        $tempTeamPlayers[AllPositionEnum::STRIKER] = $data[AllPositionEnum::STRIKER];

        return $tempTeamPlayers;
    }
}
