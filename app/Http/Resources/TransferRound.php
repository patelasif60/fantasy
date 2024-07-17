<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferRound extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);

        return [
            'id' => $this->id,
            'division_id' => $this->division_id,
            'start' => $start,
            'end' => $end,
            'startDate' => $start->format('d-m-Y'),
            'startTime' => $start->format('H:i:s'),
            'endDate' => $end->format('d-m-Y'),
            'endTime' => $end->format('H:i:s'),
            'is_end' => $end->lte(get_date_time_in_carbon(now())),
            'is_process' => $this->is_process,
            'number'=> $this->number,
        ];
    }
}
