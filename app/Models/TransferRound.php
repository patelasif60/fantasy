<?php

namespace App\Models;

use App\Enums\TransferRoundProcessEnum;
use Illuminate\Database\Eloquent\Model;

class TransferRound extends Model
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

    public function processed()
    {
        $this->update([
            'is_process' => TransferRoundProcessEnum::PROCESSED,
        ]);
    }

    /**
     * Get the SealedBidTransfers for the TransferRound.
     */
    public function sealedbidtransfers()
    {
        return $this->hasMany('App\Models\SealedBidTransfer', 'transfer_rounds_id');
    }

    public function tiepreferences()
    {
        return $this->hasMany('App\Models\TransferTiePreference', 'transfer_rounds_id');
    }
}
