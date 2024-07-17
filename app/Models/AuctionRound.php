<?php

namespace App\Models;

use App\Enums\AuctionRoundProcessEnum;
use Illuminate\Database\Eloquent\Model;

class AuctionRound extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /*
    **
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function onlineSealedBids()
    {
        return $this->hasMany(OnlineSealedBid::class, 'auction_rounds_id');
    }

    public function processed()
    {
        $this->update([
            'is_process' => AuctionRoundProcessEnum::PROCESSED,
        ]);
    }
}
