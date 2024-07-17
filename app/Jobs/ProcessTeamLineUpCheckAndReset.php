<?php

namespace App\Jobs;

use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Models\TeamPlayerContract;
use App\Repositories\TeamPlayerRepository;
use App\Services\AuctionService;
use App\Services\TransferService;
use App\Services\ValidateTransferFormationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTeamLineUpCheckAndReset implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var division
     */
    protected $division;

    /**
     * @var team
     */
    protected $team;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($division, $team)
    {
        $this->division = $division;
        $this->team = $team;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $team = $this->team;
        $division = $this->division;

        info('Process lineup reset for team'.$team->id);
        $auctionService = app(AuctionService::class);
        $transferService = app(TransferService::class);
        $validateTransferFormationService = app(ValidateTransferFormationService::class);

        $availableFormations = $division->getOptionValue('available_formations');
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $activePlayers = $transferService->getActiveTeamPlayerPostions($team);

        if (! $validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $activePlayers)) {
            info('Process lineup reset start');
            $teamPlayerRepository = app(TeamPlayerRepository::class);
            $totalPlayers = TeamPlayerContract::where('team_id', $team->id)->whereNull('end_date')->select('player_id')->get()->pluck('player_id')->toArray();
            $teamPlayerRepository->updatePlayerData($totalPlayers, $team->id);
            $teamPlayers = $transferService->getTeamPlayerContracts($team);
            $teamPlayers->filter(function ($value, $key) use ($division) {
                if ($division->getOptionValue('merge_defenders') == 'Yes') {
                    if ($value->position == AllPositionEnum::CENTREBACK || $value->position == AllPositionEnum::FULLBACK) {
                        return $value->setAttribute('position', AllPositionEnum::DEFENDER);
                    }
                }

                if ($value->position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                    return $value->setAttribute('position', AllPositionEnum::MIDFIELDER);
                }
            });

            $auctionService->setTeamFormations($division, $teamPlayers->groupBy('position'));
        }

        info('Process lineup reset end');
    }
}
