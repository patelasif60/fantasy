<?php

namespace App\Repositories;

use App\Enums\TransferRoundProcessEnum;
use App\Jobs\ProcessTransferRoundDeadlineChanged;
use App\Models\TransferRound;
use App\Services\OnlineSealedBidTransferService;
use App\Services\TransferRoundService;

class TransferRoundRepository
{
    public function store($data)
    {
        return TransferRound::create([
            'division_id' => $data['division_id'],
            'start' => $data['start'],
            'end' => $data['end'],
            'number' => $data['number'],
            'is_process' => $data['is_process'],
        ]);
    }

    public function getActiveRound($division)
    {
        return TransferRound::where('start', '<=', now())
                    ->where('is_process', TransferRoundProcessEnum::UNPROCESSED)
                    ->where('division_id', $division->id)
                    ->first();
    }

    public function getEndRound($division)
    {
        return  TransferRound::where('is_process', TransferRoundProcessEnum::UNPROCESSED)
                    ->where('end', '<=', now())
                    ->where('division_id', $division->id)
                    ->first();
    }

    public function getEndRounds($division)
    {
        return  TransferRound::where('start', '<=', now())
                    ->where('division_id', $division->id)
                    ->get();
    }

    public function getFutureActiveRound($division)
    {
        return TransferRound::where('start', '>', now())
                ->where('is_process', TransferRoundProcessEnum::UNPROCESSED)
                ->where('transfer_rounds', $division->id)
                ->first();
    }

    public function createFromLastRound($endRound, $endDt)
    {
        return TransferRound::create([
            'division_id' => $endRound->division_id,
            'start' => $endRound->end,
            'end' => $endDt,
            'number' => $endRound->number + 1,
            'is_process' => TransferRoundProcessEnum::UNPROCESSED,
        ]);
    }

    public function updateEndDate($activeRound, $date)
    {
        $activeRound->fill([
            'end' => $date,
        ]);
        $activeRound->save();

        return $activeRound;
    }

    public function updateRoundManually($division, $data)
    {
        $count = TransferRound::where('division_id', $division->id)->max('number');
        $start = '';
        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
        $transferRoundService = app(TransferRoundService::class);

        foreach ($data['round_end_date'] as $key => $value) {
            $transferRound = TransferRound::where('division_id', $division->id)->where('id', key($value))->first();

            if ($key == 0) {
                $start = $transferRound ? $transferRound->start : now();
            }
            $end = carbon_set_db_date_time($value[key($value)].' '.$data['round_end_time'][$key][key($value)]);

            if ($transferRound) {
                if ($transferRound->is_process != TransferRoundProcessEnum::PROCESSED) {
                    $transferRound->fill(['start' =>  $start, 'end' =>  $end]);
                    $isDirty = $transferRound->getDirty('end');
                    $transferRound->save();
                    if ($isDirty) {
                        ProcessTransferRoundDeadlineChanged::dispatch($division, $transferRound);
                    }
                }
            } else {
                $count++;
                $newRound = TransferRound::create([
                    'division_id' => $division->id,
                    'start' => $start,
                    'end' => $end,
                    'number'=> $count,
                ]);

                $onlineSealedBidTransferService->transferRoundTiePreference($division, $division->getOptionValue('tie_preference'), $newRound);
                $transferRoundService->sendEmailTransferRoundCreated($division, $newRound);
            }

            $start = $end;
        }
    }

    public function getEndedRound($division)
    {
        return TransferRound::where('is_process', TransferRoundProcessEnum::PROCESSED)
                    ->where('division_id', $division->id)
                    ->orderByRaw('cast(number as unsigned) desc')
                    ->first();
    }
}
