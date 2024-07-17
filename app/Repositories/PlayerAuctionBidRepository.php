<?php

namespace App\Repositories;

use App\Models\PlayerAuctionBid;

class PlayerAuctionBidRepository
{
    public function isAuctionEntryStart($division)
    {
        return PlayerAuctionBid::where('division_id', $division->id)->count();
    }
}
