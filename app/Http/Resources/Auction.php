<?php

namespace App\Http\Resources;

use App\Http\Resources\AuctionRound as AuctionRoundResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Auction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $auctionDate = '';
        $auctionTime = '12:00:00';

        if ($this->auction_date) {
            $dateTime = explode(' ', get_date_time_in_carbon($this->auction_date));
            $auctionDate = $dateTime[0];
            $auctionTime = $dateTime[1];
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'auction_types' => $this->getOptionValue('auction_types'),
            'auction_date' => $auctionDate,
            'auction_time' => $auctionTime,
            'pre_season_auction_budget' => $this->getOptionValue('pre_season_auction_budget'),
            'pre_season_auction_bid_increment' => $this->getOptionValue('pre_season_auction_bid_increment'),
            'budget_rollover' => $this->getOptionValue('budget_rollover'),
            'auction_venue' => $this->auction_venue,
            'manual_bid' => $this->getOptionValue('manual_bid'),
            'tie_preference' => $this->getOptionValue('tie_preference'),
            'allow_passing_on_nominations' =>$this->getOptionValue('allow_passing_on_nominations'),
            'remote_nomination_time_limit' => $this->remote_nomination_time_limit,
            'remote_bidding_time_limit' => $this->remote_bidding_time_limit,
            'allow_managers_to_enter_own_bids' =>  $this->getOptionValue('allow_managers_to_enter_own_bids'),
            'allow_auction_budget' => $this->getOptionValue('allow_auction_budget'),
            'allow_bid_increment' => $this->getOptionValue('allow_bid_increment'),
            'allow_rollover_budget' => $this->getOptionValue('allow_rollover_budget'),
            'auctioneer_id' =>  $this->auctioneer_id,
            'auction_closing_date' =>  $this->auction_closing_date,
            'auctionRounds' => AuctionRoundResource::collection($this->whenLoaded('auctionRounds')),
            'auction_started'=> (Carbon::parse($this->auction_date)->timestamp < Carbon::now()->timestamp) && $this->auction_closing_date == null ? true : false,
        ];
    }
}
