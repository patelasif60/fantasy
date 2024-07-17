<?php

namespace App\Repositories;

use App\Enums\AuctionRoundProcessEnum;
use App\Models\AuctionRound;
use Carbon\Carbon;

class AuctionRoundRepository
{
    public function getActiveRound($division)
    {
        return AuctionRound::where('start', '<=', now())
                    ->where('is_process', AuctionRoundProcessEnum::UNPROCESSED)
                    ->where('division_id', $division->id)
                    ->first();
    }

    public function getEndRound($division)
    {
        return  AuctionRound::where('is_process', AuctionRoundProcessEnum::UNPROCESSED)
                    ->where('end', '<=', now())
                    ->where('division_id', $division->id)
                    ->first();
    }

    public function getNextRoundCount($division)
    {
        return  AuctionRound::where('is_process', AuctionRoundProcessEnum::UNPROCESSED)
                    ->where('end', '>=', now())
                    ->where('division_id', $division->id)
                    ->count();
    }

    public function getEndRounds($division)
    {
        return  AuctionRound::where('start', '<=', now())
                    ->where('division_id', $division->id)
                    ->get();
    }

    public function getFutureActiveRound($division)
    {
        return AuctionRound::where('start', '>', now())
                ->where('is_process', AuctionRoundProcessEnum::UNPROCESSED)
                ->where('division_id', $division->id)
                ->first();
    }

    public function createFromLastRound($endRound)
    {
        $endDt = Carbon::createFromFormat(config('fantasy.date_fixture.datetime_format'), $endRound->end);

        return AuctionRound::create([
            'division_id' => $endRound->division_id,
            'start' => $endRound->end,
            'end' => $endDt->addHour(24),
            'number' => $endRound->number + 1,
            'is_process' => AuctionRoundProcessEnum::UNPROCESSED,
        ]);
    }

    public function create($division, $data)
    {
        $round = $division->auctionRounds()->create([
            'start' => Arr::get($data, 'start'),
            'end' => Arr::get($data, 'end'),
            'number' => Arr::get($data, 'number'),
            'is_process' => Arr::get($data, 'is_process', AuctionRoundProcessEnum::UNPROCESSED),
        ]);

        return $round;
    }
}
