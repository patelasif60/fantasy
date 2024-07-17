<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\YesNoEnum;
use Illuminate\Support\Arr;
use App\Enums\PositionsEnum;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PlayerContractPosition\MergeDefenderDefensiveMidfielderEnum;
use App\Enums\PlayerContractPosition\MergeDefenderNoDefensiveMidfielderEnum;
use App\Enums\PlayerContractPosition\UnMergeDefenderDefensiveMidfielderEnum;
use App\Enums\PlayerContractPosition\UnMergeDefenderNoDefensiveMidfielderEnum;

class Division extends Model
{
    /**
     * The attributes that aren't mass assignable.
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
        'available_formations' => 'array',
        'is_round_process' => 'boolean',
        'is_legacy' => 'boolean',
        'is_viewed_package_selection' => 'boolean',
    ];

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'chairman_id');
    }

    public function divisons()
    {
        return $this->hasMany(self::class, 'parent_division_id');
    }

    public function parentDivision()
    {
        return $this->belongsTo(self::class, 'parent_division_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function coChairmen()
    {
        return $this->belongsToMany(Consumer::class, 'division_co_chairman', 'division_id', 'co_chairman_id');
    }

    public function customCup()
    {
        return $this->hasMany(CustomCup::class);
    }

    public function histories()
    {
        return $this->hasMany(PastWinnerHistory::class);
    }

    public function divisionTeams()
    {
        return $this->belongsToMany(Team::class, 'division_teams', 'division_id', 'team_id')
                ->withPivot('payment_id', 'season_id');
    }

    public function divisionTeamsCurrentSeason()
    {
        return $this->divisionTeams()->where('season_id', Season::getLatestSeason());
    }

    public function scopeActive($query)
    {
        return $query->whereNull('parent_division_id');
    }

    public function inviteCode()
    {
        return $this->hasOne(InviteCode::class);
    }

    public function getOptionValue($columnName, $events = null)
    {
        if (is_null($events)) {
            if (! is_null($this->$columnName)) {
                return $this->$columnName;
            }

            return $this->package->$columnName;
        }
        foreach ($this->divisionPoints as $key => $value) {
            if ($value->events == $events && ! is_null($value->$columnName)) {
                return $value->$columnName;
            }
        }

        foreach ($this->package->packagePoints as $key => $value) {
            if ($value->events == $events && ! is_null($value->$columnName)) {
                return $value->$columnName;
            }
        }
    }

    public function divisionPoints()
    {
        return $this->hasMany(DivisionPoint::class);
    }

    public function auctionRounds()
    {
        return $this->hasMany(AuctionRound::class, 'division_id');
    }

    public function getDivisionImageThumb($user = null)
    {
        if ($user) {
            $consumer = $user->consumer->id;
        } else {
            $consumer = auth()->user()->consumer->id;
        }

        $team = $this->divisionTeams()->approve()->where('manager_id', $consumer)->first();

        if ($team) {
            return $team->getCrestImageThumb();
        }

        return asset('assets/frontend/img/default/square/default-thumb-100.png');
    }

    public function getPrice()
    {
        return Arr::has($this->prizePack, 'price') ? number_format((float) $this->package->price + $this->prizePack->price, 2, '.', '') : $this->package->price;
    }

    public function isPaid()
    {
        if ($this->getPrice() == 0) {
            return true;
        }

        $unPaid = $this->divisionTeams()->where('is_approved', true)->wherePivot('payment_id', null);

        if ($unPaid->count() > 0) {
            $unPaid = $this->divisionTeams()->where('is_approved', true)->whereNull('payment_id')->where('is_free', 0);

            return $unPaid->count() > 0 ? false : $this->getPrize() == 0 ? true : false;
        }

        return true;
    }

    public function isPreAuctionState()
    {
        if ($this->auction_date == null) {
            return true;
        }
        $auctionDate = Carbon::parse($this->auction_date);

        return  $auctionDate->greaterThan(Carbon::now()) ? true : false;

        // $auctionDate = Carbon::parse($this->auction_date);
        // return ($auctionDate->greaterThan(Carbon::now())) ? false : true;

        // if ($this->auction_date == null || $this->auction_closing_date == null) {
        //     return true;
        // }
        // $auctionDate = Carbon::parse($this->auction_date);
        // $auctionCloseDate = Carbon::parse($this->auction_closing_date);

        // return ($auctionDate->greaterThan(Carbon::now()) && $auctionCloseDate->greaterThan(Carbon::now())) ? true : false;
    }

    public function isInAuctionState()
    {
        if ($this->auction_date == null) {
            return false;
        }
        $auctionDate = Carbon::parse($this->auction_date);
        $auctionCloseDate = Carbon::parse($this->auction_closing_date);

        return ($auctionDate->lessThan(Carbon::now()) && ($this->auction_closing_date == null || $auctionCloseDate->greaterThan(Carbon::now()))) ? true : false;
    }

    public function isPostAuctionState()
    {
        if (! $this->auction_closing_date) {
            return false;
        }

        $auctionCloseDate = Carbon::parse($this->auction_closing_date);

        return ($auctionCloseDate->lessThan(Carbon::now())) ? true : false;
    }

    public function isMinimumPaid()
    {
        $paid = $this->divisionTeams()->wherePivot('payment_id', '<>', null);

        return ($paid->count() >= $this->package->minimum_teams) ? true : false;
    }

    public function paidTeamsCount()
    {
        if ($this->getPrice() > 0) {
            if ($this->getPrize() == 0) {
                return $this->divisionTeams()->approve()->where(function ($query) {
                    $query->whereNotNull('payment_id')->orWhere('is_free', 1);
                })->count();
            }

            return $this->divisionTeams()->approve()->wherePivot('payment_id', '<>', null)->count();
        } else {
            return $this->divisionTeams()->approve()->count();
        }
    }

    public function isLeagueAccessible()
    {
        if ($this->isPreAuctionState()) {
            return false;
        }

        return ($this->isPaid()) ? true : false;
    }

    public function isDMFOn()
    {
        return ($this->getOptionValue('defensive_midfields') == 'No') ? false : true;
    }

    public function isMergeDefendersOn()
    {
        return ($this->getOptionValue('merge_defenders') == 'No') ? false : true;
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function roundProcess($status)
    {
        $this->update([
            'is_round_process' => $status,
        ]);
    }

    public function playerPositionEnum()
    {
        if ($this->isMergeDefendersOn() && $this->isDMFOn()) {
            return MergeDefenderDefensiveMidfielderEnum::class;
        }
        if (! $this->isMergeDefendersOn() && ! $this->isDMFOn()) {
            return UnMergeDefenderNoDefensiveMidfielderEnum::class;
        }
        if (! $this->isMergeDefendersOn() && $this->isDMFOn()) {
            return UnMergeDefenderDefensiveMidfielderEnum::class;
        }
        if ($this->isMergeDefendersOn() && ! $this->isDMFOn()) {
            return MergeDefenderNoDefensiveMidfielderEnum::class;
        }
    }

    public function transferRounds()
    {
        return $this->hasMany(TransferRound::class, 'division_id');
    }

    public function isFirstManagerPaid()
    {
        if ($this->getPrice() == 0) {
            return false;
        }
        $paid = $this->divisionTeams()->wherePivot('payment_id', '!=', null);

        return ($paid->count() > 0) ? true : false;
    }

    public function prizePack()
    {
        return $this->belongsTo(PrizePack::class, 'prize_pack');
    }

    public function getPrize()
    {
        return Arr::has($this->prizePack, 'price') ? number_clean($this->prizePack->price) : 0;
    }

    public function allTeamsSquadFull()
    {
        foreach ($this->divisionTeams as $key => $value) {
            if ($value->is_approved) {
                if ($value->isTeamSquadFull() != true) {
                    return false;
                }
            }
        }

        return true;
    }

    public function allOnlineAuctionTeamsSquadFull()
    {
        foreach ($this->divisionTeams as $key => $value) {
            if ($value->isTeamSquadFullForOnlineAuction() != true) {
                return false;
            }
        }

        return true;
    }

    public function auctionCloseAndTeamFull()
    {
        return $this->isPostAuctionState() && $this->allTeamsSquadFull() ? true : false;
    }

    public function isAuctionSet()
    {
        return $this->auction_date ? true : false;
    }

    public function divisionTeamsWithoutPivot()
    {
        return $this->hasMany(DivisionTeam::class, 'division_id');
    }

    public function getPositionShortCode($position)
    {
        $mergeDefenders = $this->getOptionValue('merge_defenders');
        $defensiveMidfields = $this->getOptionValue('defensive_midfields');

        if ($mergeDefenders == YesNoEnum::YES && ($position == player_position_short(AllPositionEnum::CENTREBACK) || $position == player_position_short(AllPositionEnum::FULLBACK))) {
            return player_position_short(AllPositionEnum::DEFENDER);
        }

        if ($defensiveMidfields == YesNoEnum::YES && $position == player_position_short(AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
            return 'DM';
        } elseif ($defensiveMidfields == YesNoEnum::NO && $position == player_position_short(AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
            return player_position_short(AllPositionEnum::MIDFIELDER);
        }

        return $position;
    }

    public function getPositionFullCode($position)
    {
        $mergeDefenders = $this->getOptionValue('merge_defenders');
        $defensiveMidfields = $this->getOptionValue('defensive_midfields');

        if ($mergeDefenders == YesNoEnum::YES && ($position == AllPositionEnum::CENTREBACK || $position == AllPositionEnum::FULLBACK)) {
            return AllPositionEnum::DEFENDER;
        }

        if ($defensiveMidfields == YesNoEnum::NO && $position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
            return AllPositionEnum::MIDFIELDER;
        }

        return $position;
    }

    public function getPositionFullName($position)
    {
        if ($position == 'DM') {
            return AllPositionEnum::DEFENSIVE_MIDFIELDER;
        }

        return player_position_full($position);
    }

    public function checkMinimumTeams()
    {
        if ($this->divisionTeams->count() >= $this->package->minimum_teams) {
            return true;
        }

        return false;
    }

    public function divisionApprovedTeams()
    {
        return $this->divisionTeams()->where('is_approved', true)
        ->get();
    }

    public function getPositionOrder()
    {
        return [
            'GK' => 1,
            'FB' => 2,
            'CB' => 3,
            'DF' => 4,
            'DM' => 5,
            'DMF' => 6,
            'MF' => 7,
            'ST' => 8,
        ];
    }

    public function isCustomisedScoring()
    {
        $strQuery = 'sum('.PositionsEnum::GOAL_KEEPER.') as gk';
        $strQuery .= ', sum('.PositionsEnum::CENTER_BACK.') as cb';
        $strQuery .= ', sum('.PositionsEnum::FULL_BACK.') as fb';
        $strQuery .= ', sum('.PositionsEnum::DEFENSIVE_MIDFIELDER.') as dmf';
        $strQuery .= ', sum('.PositionsEnum::MIDFIELDER.') as mf';
        $strQuery .= ', sum('.PositionsEnum::STRIKER.') as st';

        $data = DivisionPoint::where('division_id', $this->id)
                            ->selectRaw($strQuery)
                            ->first();

        if (isset($data) && ! empty($data)) {
            foreach ($data->toArray() as $key => $value) {
                if ($value != 0 && $value != null) {
                    return true;
                }
            }
        }

        return false;
    }

    public function checkIsDivisionTeam($team)
    {
        if ($this->divisionApprovedTeams()
            ->where('id', $team->id)
            ->count()
        ) {
            return true;
        }

        return false;
    }

    public function getChampionTeam()
    {
        return $this->hasOne(Team::class, 'id', 'champions_league_team');
    }

    public function getEuropaTeamOne()
    {
        return $this->hasOne(Team::class, 'id', 'europa_league_team_1');
    }

    public function getEuropaTeamTwo()
    {
        return $this->hasOne(Team::class, 'id', 'europa_league_team_2');
    }

    public function getSeason()
    {
        $data = $this->divisionTeams->first();
        if($data) {
            $season = $data->pivot->season_id;
        } else {
            $season = Season::getLatestSeason();
        }

        return $season;
    }

    public function auctionBasic($user)
    {
        $division = $this;
        $data = [];
        $data['ownLeague'] = $user->can('ownLeagues', $division);
        $data['auction_types']  = $division->getOptionValue('auction_types');
        $data['auction_date']  = $division->auction_date;
        $data['auction_closed']  = ($division->auction_date && ! $division->auction_closing_date && now()->format(config('fantasy.db.date.format')) >= $division->auction_date) ? false : true ;
        $data['is_preauction_state']  = $division->isPreauctionState();
        $data['is_inauction_state']  = $division->isInAuctionState();
        $data['is_paid'] = $division->isPaid();
        $data['is_auction_closed'] = $division->isPostAuctionState();
        $data['is_league_accessible'] = $division->isLeagueAccessible();
        $data['managerHasPaidTeam'] = $division->isFirstManagerPaid();

        return $data;
    }

    public function getDivisionFromUuid()
    {
        return Division::where('uuid', $this->uuid)->pluck('id');
    }
}
