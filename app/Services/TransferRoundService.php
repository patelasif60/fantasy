<?php

namespace App\Services;

use App\Enums\SealedBidDeadLinesEnum;
use App\Enums\TransferRoundProcessEnum;
use App\Jobs\ProcessTransferRoundCreated;
use App\Repositories\TransferRoundRepository;
use Carbon\Carbon;

class TransferRoundService
{
    /**
     * The TransferRoundRepository repository instance.
     *
     * @var TransferRoundRepository
     */
    protected $repository;

    public function __construct(TransferRoundRepository $repository)
    {
        $this->repository = $repository;
    }

    public function firstRoundStore($division)
    {
        $endDt = $this->deadlineRepeat(
            $division->getOptionValue('seal_bid_deadline_repeat'),
            $division->auction_closing_date,
            'first'
        );

        $data = [];
        $data['division_id'] = $division->id;
        $data['start'] = $division->auction_closing_date;
        $data['end'] = $endDt;
        $data['number'] = 1;
        $data['is_process'] = TransferRoundProcessEnum::UNPROCESSED;

        return $this->repository->store($data);
    }

    public function deadlineRepeat($deadLineRepeat, $date, $round = null)
    {
        if ($round === 'first') {
            $endDt = Carbon::parse(date('Y').'/08/31 00:00:00');
            if ($endDt->lte(now())) {
                $endDt = Carbon::parse('last friday of this month');
            }
            $endDt = $endDt->addHours(12);
        } else {
            $endDt = Carbon::parse($date);
            if ($deadLineRepeat == SealedBidDeadLinesEnum::EVERYFORTNIGHT) {
                $endDt = $endDt->addDays(14);
            } elseif ($deadLineRepeat == SealedBidDeadLinesEnum::EVERYWEEK) {
                $endDt = $endDt->addWeek();
            } else {
                $endDt = $endDt->addMonth();
            }
        }

        return $endDt->setTimezone('UTC');
    }

    public function getActiveRound($division)
    {
        return $this->repository->getActiveRound($division);
    }

    public function getEndRound($division)
    {
        return $this->repository->getEndRound($division);
    }

    public function getEndRounds($division)
    {
        return $this->repository->getEndRounds($division);
    }

    public function getTransfers($division)
    {
        return $this->repository->getTransfers($division);
    }

    public function createFromLastRound($division, $endRound)
    {
        if ($division->getOptionValue('seal_bid_deadline_repeat') === SealedBidDeadLinesEnum::DONTREPEAT) {
            return;
        }

        $endDt = $this->deadlineRepeat(
            $division->getOptionValue('seal_bid_deadline_repeat'),
            $endRound->end
        );

        return $this->repository->createFromLastRound($endRound, $endDt);
    }

    public function getFutureActiveRound($division)
    {
        return $this->repository->getFutureActiveRound($division);
    }

    public function getRound($division)
    {
        $round = $this->getActiveRound($division);

        if (! $round) {
            $round = $this->getFutureActiveRound($division);
        }

        return $round;
    }

    public function updateEndDate($activeRound, $date)
    {
        return $this->repository->updateEndDate($activeRound, $date);
    }

    public function updateRoundManually($division, $data)
    {
        return $this->repository->updateRoundManually($division, $data);
    }

    public function unprocessRoundCount($division)
    {
        $unprocessRoundCount = $division->transferRounds()->where('is_process', TransferRoundProcessEnum::UNPROCESSED)->count();
        // if($unprocessRoundCount >= 1) {
        //     $round = $this->getActiveRound($division);
        //     $sealedBidTransferService = app(SealedBidTransferService::class);
        //     $isRoundProcessed = $sealedBidTransferService->isRoundProcessed($round);
        //     $unprocessRoundCount  = $isRoundProcessed ? 0 : $unprocessRoundCount;
        // }

        return $unprocessRoundCount;
    }

    public function sendEmailTransferRoundCreated($division, $round)
    {
        ProcessTransferRoundCreated::dispatch($division, $round);
    }
}
