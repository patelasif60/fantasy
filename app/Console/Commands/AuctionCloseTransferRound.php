<?php

namespace App\Console\Commands;

use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Models\Division;
use App\Models\SealedBidTransfer;
use App\Models\TransferRound;
use App\Models\TransferTiePreference;
use App\Repositories\TransferRoundRepository;
use App\Services\OnlineSealedBidTransferService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AuctionCloseTransferRound extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online-sealed-bids:create-transfers-first-round';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After auction create first seal bid round';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $divisions = Division::whereNotNull('auction_closing_date')->get();

        $this->info('Number of Division Found '.$divisions->count());

        $transferRoundRepository = app(TransferRoundRepository::class);

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SealedBidTransfer::truncate();
        TransferRound::truncate();
        TransferTiePreference::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($divisions as $division) {
            $this->info('Start for division '.$division->id);

            $endDt = Carbon::parse(date('Y').'/08/31 00:00:00');
            if ($endDt->lte(now())) {
                $endDt = Carbon::parse('last friday of this month');
            }

            $endDt = $endDt->setTimezone(config('fantasy.date.timezone'))
                    ->startOfDay()
                    ->addHours(12)
                    ->setTimezone('UTC');

            if ($division->transferRounds->count()) {
                $round = $division->transferRounds->first();
                $round->end = $endDt;
                $round->save();
            } else {
                $data = [];
                $data['division_id'] = $division->id;
                $data['start'] = $division->auction_closing_date;
                $data['end'] = $endDt;
                $data['number'] = 1;
                $data['is_process'] = TransferRoundProcessEnum::UNPROCESSED;

                $round = $transferRoundRepository->store($data);
            }

            $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
            $tiePreference = TiePreferenceEnum::RANDOMLY_ALLOCATED;
            $onlineSealedBidTransferService->transferRoundTiePreference($division, $tiePreference, $round);

            $division->fill([
                'seal_bid_deadline_repeat' => SealedBidDeadLinesEnum::DONTREPEAT,
            ]);

            $division->save();
        }
    }
}
