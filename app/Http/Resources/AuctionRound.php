<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AuctionRound extends JsonResource
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
                'start_date' => $start->format('Y-m-d'),
                'start_time' => $start->format('H:i:s'),
                'is_start' => $start->lte(now()),
                'end_date' => $end->format('Y-m-d'),
                'end_time' => $end->format('H:i:s'),
                'is_end' => $end->lte(now()),
                'is_active' => $start->gte(now()) && $end->lte(now()),
                'number'=> $this->number,
                'is_process'=> $this->is_process,
                'next_number'=> $this->number + 1,
        ];
    }
}
