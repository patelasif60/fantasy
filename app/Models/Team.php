<?php

namespace App\Models;

use App\Enums\TransferTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Team extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'manager_id' => 'integer',
        'crest_id' => 'integer',
        'division_id' => 'integer',
        'is_approved' => 'boolean',
        'is_ignored' => 'boolean',
        'is_legacy' => 'boolean',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 250, 250)
            ->performOnCollections('crest');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('crest')
            ->singleFile();
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'manager_id');
    }

    public function divisionTeam()
    {
        return $this->belongsTo(DivisionTeam::class, 'id', 'team_id');
    }

    public function scopeCurrentSeason()
    {
        return $this->divisionTeam()->where('season_id', Season::getLatestSeason());
    }

    public function teamDivision()
    {
        return $this->belongsToMany(Division::class, 'division_teams', 'team_id', 'division_id')->withPivot('season_id');
    }

    public function teamPlayerContract()
    {
        return $this->hasOne(TeamPlayerContract::class);
    }

    public function teamPlayerContracts()
    {
        return $this->hasMany(TeamPlayerContract::class);
    }

    public function teamPlayerOnlineAuctionContracts()
    {
        return $this->hasMany(PlayerAuctionBid::class);
    }

    public function Pitch()
    {
        return $this->belongsTo(Pitch::class);
    }

    public function transfer()
    {
        return $this->hasMany(Transfer::class);
    }

    public function onlineSealedBids()
    {
        return $this->hasMany(OnlineSealedBid::class);
    }

    public function onlineSealedBidsTransfer()
    {
        return $this->hasMany(SealedBidTransfer::class);
    }

    public function transferSealbidValue()
    {
        return $this->transfer()->where('transfer_type', TransferTypeEnum::SEALEDBIDS)->groupBy('player_in', 'id');
    }

    /**
     * Scope a query to only include active teams.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApprove($query)
    {
        return $query->where('is_approved', true);
    }

    public function getCrestImageThumb()
    {
        $url = asset('assets/frontend/img/default/square/default-thumb-100.png');

        // if (config('fantasy.crest_show_live') != 'true') {
        //     return $url;
        // }

        if (isset($this->crest_id) && $this->crest_id != null) {
            $crest = PredefinedCrest::find($this->crest_id);

            $url = $crest->getMedia('crest')->last()->getUrl('thumb');
        } elseif (! empty($this->getMedia('crest')->last())) {
            $url = $this->getMedia('crest')->last()->getUrl('thumb');
        }

        return $url;
    }

    public function getPitchImageThumb()
    {
        $defaultUrl = asset('/assets/frontend/img/pitch/pitch-1.png');

        if ($this->pitch_id && $this->pitch_id != null) {
            $pitch = Pitch::ispublished()->find($this->pitch_id);

            return $pitch ? $pitch->getMedia('crest')->last()->getUrl('thumb') : $defaultUrl;
        }

        return $defaultUrl;
    }

    public function isPaid()
    {
        $price = Division::find($this->teamDivision->first()->id)->getPrice();

        if ($price == 0) {
            return true;
        }

        $divisionTeams = DivisionTeam::where('team_id', $this->id)->whereNotNull('payment_id');

        if ($divisionTeams->count() == 0) {
            $divisionTeams = DivisionTeam::where('team_id', $this->id)->where(function ($query) {
                $query->whereNotNull('payment_id')
                ->orWhere('is_free', 1);
            });

            return $divisionTeams->count() == 0 ? false : 'strike';
        }

        return true;
    }

    public function getPrize()
    {
        return Division::find($this->teamDivision->first()->id)->getPrize();
    }

    public function teamPlayers()
    {
        return $this->teamPlayerContracts();
    }

    public function transferBudget()
    {
        return $this->transfer()->where('transfer_type', TransferTypeEnum::AUCTION);
    }

    public function teamBudget()
    {
        return $this->transfer()->selectRaw('SUM(transfer_value) as transfer_value')->where('transfer_type', TransferTypeEnum::AUCTION);
    }

    public function tiePreferences()
    {
        return $this->hasOne(AuctionTiePreference::class);
    }

    public function teamPlayerPoints()
    {
        return $this->hasMany(TeamPlayerPoint::class);
    }

    public function activeTeamPlayers()
    {
        return $this->teamPlayerContracts()->whereNull('end_date');
    }

    public function isTeamSquadFull()
    {
        return ($this->teamDivision->first()->getOptionValue('default_squad_size') == $this->activeTeamPlayers()->count()) ? true : false;
    }

    public function isOnlyPaid()
    {
        $divisionTeams = DivisionTeam::where('team_id', $this->id)->whereNotNull('payment_id');

        return $divisionTeams->count() ? true : false;
    }

    public function activeTeamPlayersFromOnlineAuction()
    {
        return $this->teamPlayerOnlineAuctionContracts();
    }

    public function isTeamSquadFullForOnlineAuction()
    {
        return ($this->teamDivision->first()->getOptionValue('default_squad_size') == $this->activeTeamPlayersFromOnlineAuction()->count()) ? true : false;
    }
}
