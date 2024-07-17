<?php

namespace App\Policies;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Enums\YesNoEnum;
use App\Models\Division;
use App\Models\Fixture;
use App\Enums\Role\RoleEnum;
use App\Models\TransferRound;
use App\Enums\AuctionTypesEnum;
use App\Services\DivisionService;
use App\Enums\TransferAuthorityEnum;
use App\Services\LeaguePaymentService;
use App\Enums\Division\PaymentStatusValEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class DivisionPolicy
{
    use HandlesAuthorization;

    protected $service;

    public function __construct(LeaguePaymentService $service)
    {
        $this->service = $service;
    }

    public function view(User $user, Division $division)
    {
        if ($user->hasRole(RoleEnum::SUPERADMIN)) {
            
            return true;
        }

        if ($user->consumer->ownLeagues($division) || $user->consumer->coChairmanOwnLeagues($division) || $user->consumer->ownTeam($division) || $user->consumer->ownTeamInParentAssociatedLeague($division)) {

            return true;
        }

        return false;
    }

    public function update(User $user, Division $division)
    {
        if ($user->hasRole(RoleEnum::SUPERADMIN)) {
            return true;
        }

        return $user->consumer->ownLeagues($division) || $user->consumer->coChairmanOwnLeagues($division);
    }

    public function accessTab(User $user, Division $division, $ownTeamsCheck = false, $type = null)
    {
        if ($type == 'auction') {

            return false;
        }

        if ($ownTeamsCheck) {

            if ($this->ownLeagues($user, $division)) {

                return true;
            }

            $status = $this->service->getLeaguePaymentStatus($division, $user->consumer);

            return ($status == PaymentStatusValEnum::PENDING) ? false : true;
        }

        return ($division->isLeagueAccessible()) ? true : false;
    }

    public function accessPaidTeams(User $user, Division $division)
    {
        if ($this->ownLeagues($user, $division)) {

            return true;
        }

        return $division->isPaid() ? true : false;
    }

    public function accessPreAuctionState(User $user, Division $division, $allowChairman = false)
    {
        if ($division->isPreAuctionState() || $division->isInAuctionState()) {

            return $this->ownLeagues($user, $division) ? $allowChairman : true;
        }

        return false;
    }

    public function allowProCup(User $user, Division $division)
    {
        return $division->package->allow_pro_cup == YesNoEnum::YES ? true : false;
    }

    public function allowChampionLeague(User $user, Division $division)
    {
        return $division->package->allow_champion_league == YesNoEnum::YES ? true : false;
    }

    public function allowEuropaLeague(User $user, Division $division)
    {
        return $division->package->allow_europa_league == YesNoEnum::YES ? true : false;
    }

    public function allowChampionEuropaLeague(User $user, Division $division)
    {
        return ($division->package->allow_europa_league == YesNoEnum::YES || $division->package->allow_champion_league == YesNoEnum::YES) ? true : false;
    }

    public function isEuropeanTournamentAvailable(User $user, Division $division)
    {
        $service = app(DivisionService::class);
        if ($user->consumer->ownLeaguesNav($division)) {
            
            return true;
        }

        return $service->checkEuropeanTournamentAvailable($division);
    }

    public function allowHeadToHead(User $user, Division $division)
    {
        return $division->package->allow_head_to_head == YesNoEnum::YES ? true : false;
    }

    public function allowHeadToHeadChairmanOrManager(User $user, Division $division)
    {
        return $this->allowHeadToHead($user, $division) && $this->view($user, $division);
    }

    public function allowFaCup(User $user, Division $division)
    {
        return $division->package->allow_fa_cup == YesNoEnum::YES ? true : false;
    }

    public function allowCustomCupChairman(User $user, Division $division)
    {
        return $this->allowCustomCup($user, $division) ? ($this->ownLeagues($user, $division) ? true : false) : false;
    }

    public function allowCustomCup(User $user, Division $division)
    {
        return $division->isPostAuctionState() && $division->package->allow_custom_cup == YesNoEnum::YES ? true : false;
    }

    public function ownLeagues(User $user, Division $division)
    {
        return $user->consumer->ownLeagues($division) || $user->consumer->coChairmanOwnLeagues($division);
    }

    public function ownLeaguesNav(User $user, Division $division)
    {
        return $user->consumer->ownLeaguesNav($division);
    }

    public function allowAuction(User $user, Division $division)
    {
        return $user->consumer->ownLeagues($division) || $user->consumer->coChairmanOwnLeagues($division);
    }

    public function ownTeam(User $user, Division $division)
    {
        return $user->consumer->ownTeam($division);
    }

    public function checkMaxTeamsQuota(User $user, Division $division)
    {
        return $division->divisionTeams->count() < $division->package->maximum_teams ? true : false;
    }

    public function isPrivateLeague(User $user, Division $division)
    {
        return $division->package->private_league && YesNoEnum::YES;
    }

    public function isSocialLeague(User $user, Division $division)
    {
        return $division->package->private_league && YesNoEnum::NO;
    }

    public function isAuctionSealBid(User $user, Division $division)
    {
        return $division->auction_types === AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION;
    }

    public function isAuctionStart(User $user, Division $division)
    {
        return $division->auction_date && $division->auction_date <= now();
    }

    public function isAuctionEnd(User $user, Division $division)
    {
        if (! $division->auction_closing_date) {
            return true;
        }

        return $division->auction_closing_date >= now();
    }

    public function isAuctionProcessManual(User $user, Division $division)
    {
        return $division->manual_bid == YesNoEnum::YES;
    }

    public function isAuctionActive(User $user, Division $division)
    {
        return $division->isInAuctionState();
    }

    public function isTeamManager(User $user, Team $team)
    {
        return $team->manager_id === $user->consumer->id;
    }

    public function isChairmanOrManager(User $user, Division $division, Team $team = null)
    {
        return $this->ownLeagues($user, $division) || ($team && $this->isTeamManager($user, $team));
    }

    public function chairmanCanProcessBids(User $user, Division $division, TransferRound $round = null)
    {
        if ($division->is_round_process) {
            return false;
        }

        return $this->ownLeagues($user, $division) && ($round && Carbon::parse($round->end)->lte(now()));
    }

    public function sealBidAuctionChairman(User $user, Division $division, Team $team)
    {
        if ($this->isTeamManager($user, $team)) {

            return $this->isAuctionSealBid($user, $division) && $this->isAuctionActive($user, $division);
        }

        return false;
    }

    public function sealBidAuctionChairmanOrManager(User $user, Division $division, Team $team)
    {
        if ($this->isChairmanOrManager($user, $division, $team)) {

            return $this->isAuctionSealBid($user, $division) && $this->isAuctionActive($user, $division);
        }

        return false;
    }

    public function sealBidAuction(User $user, Division $division, $team = null)
    {
        $chkFlag = true;
        if ($team && ! $this->checkIsDivisionTeam($user, $division, $team)) {

            $chkFlag = false;
        }

        if ($chkFlag && ($user->can('ownTeam', $division) || $user->can('ownLeagues', $division))) {

            return $user->can('isAuctionSealBid', $division) && $user->can('isAuctionActive', $division);
        }

        return false;
    }

    public function sealBidAuctionProcess(User $user, Division $division)
    {
        $auctionDate = Carbon::parse($division->auction_date);

        return $user->can('isAuctionProcessManual', $division) && $user->can('ownLeagues', $division) && $user->can('isAuctionSealBid', $division) && $auctionDate->lessThan(Carbon::now());
    }

    public function isAuctionLiveOffline(User $user, Division $division)
    {
        return $division->auction_types === AuctionTypesEnum::OFFLINE_AUCTION;
    }

    public function liveOfflineAuctionChairman(User $user, Division $division)
    {
        return $user->can('ownLeagues', $division) && $user->can('isAuctionLiveOffline', $division) && $user->can('isAuctionActive', $division) && !$division->isPostAuctionState();
    }

    public function liveOfflineAuctionManager(User $user, Division $division)
    {
        return $user->can('ownTeam', $division) && $user->can('isAuctionLiveOffline', $division) && $user->can('isAuctionActive', $division) && !$division->isPostAuctionState();
    }

    public function liveOfflineAuctionChairmanOrManager(User $user, Division $division, $team = null)
    {
        return ($this->ownLeagues($user, $division) || $user->consumer->coChairmanOwnLeagues($division) || ($team && $this->isTeamManager($user, $team) || $this->ownTeamInParentAssociatedLeague($user, $division))) && $user->can('isAuctionActive', $division);
    }

    public function isAuctionLiveOnline(User $user, Division $division)
    {
        return $division->auction_types === AuctionTypesEnum::LIVE_ONLINE_AUCTION;
    }

    public function liveOnlineAuctionChairman(User $user, Division $division)
    {
        return $user->can('ownLeagues', $division) && $user->can('isAuctionLiveOnline', $division) && $user->can('isAuctionActive', $division);
    }

    public function liveOnlineAuctionManager(User $user, Division $division)
    {
        return $user->can('ownTeam', $division) && $user->can('isAuctionLiveOnline', $division) && $user->can('isAuctionActive', $division);
    }

    public function liveOnlineAuctionChairmanOrManager(User $user, Division $division)
    {
        if ($this->liveOnlineAuctionManager($user, $division) || $this->liveOnlineAuctionChairman($user, $division)) {

            return true;
        }

        return false;
    }

    public function transferChairmanOrManager(User $user, Division $division)
    {
        if ($this->transferManager($user, $division) || $this->transferChairman($user, $division)) {

            return true;
        }

        return false;
    }

    public function transferChairman(User $user, Division $division)
    {
        return $user->can('ownLeagues', $division);
    }

    public function transferManager(User $user, Division $division)
    {
        return $user->can('ownTeam', $division);
    }

    public function isTransferEnabled(User $user, Division $division)
    {
        $allowWeekendSwap = true;
        if ($division->getOptionValue('allow_weekend_changes') == YesNoEnum::NO) {
            $chkFlag = Fixture::checkFixtureForSwap();
            $allowWeekendSwap = ! $chkFlag ? true : false;
        }

        if ($division->getOptionValue('enable_free_agent_transfer') != YesNoEnum::YES || ! $allowWeekendSwap) {

            return false;
        }
        if ($division->getOptionValue('free_agent_transfer_authority') == TransferAuthorityEnum::ALL) {

            return true;
        }
        if ($division->getOptionValue('free_agent_transfer_authority') == TransferAuthorityEnum::CHAIRMAN && $user->consumer->ownLeagues($division)) {

            return true;
        }

        $divisionCochairmen = $division->coChairmen->pluck('id')->toArray();

        if ($division->getOptionValue('free_agent_transfer_authority') == TransferAuthorityEnum::CHAIRMAN_AND_COCHAIRMAN && ($user->consumer->ownLeagues($division) || in_array($user->consumer->id, $divisionCochairmen))) {

            return true;
        }

        return false;
    }

    public function managerHasPaidTeam(User $user, Division $division)
    {
        return $division->isFirstManagerPaid();
    }

    public function isChairmanOrManagerOrParentleague(User $user, Division $division, Team $team = null)
    {
        return $this->ownLeagues($user, $division) || $user->consumer->coChairmanOwnLeagues($division) || ($team && $this->isTeamManager($user, $team) || $this->ownTeamInParentAssociatedLeague($user, $division));
    }

    public function ownTeamInParentAssociatedLeague(User $user, Division $division)
    {
        return $user->consumer->ownTeamInParentAssociatedLeague($division);
    }

    public function checkIsDivisionTeam(User $user, Division $division, $team)
    {
        return $division->checkIsDivisionTeam($team);
    }

    public function isChairmanOrManagerAndOwnDivision(User $user, Division $division, $team)
    {
        return $this->isChairmanOrManager($user, $division, $team) &&
               $this->checkIsDivisionTeam($user, $division, $team);
    }

    public function isChairmanOrManagerOrParentleagueAndOwnDivision(User $user, Division $division, Team $team = null)
    {
        return $this->checkIsDivisionTeam($user, $division, $team) && (($this->ownLeagues($user, $division) || $user->consumer->coChairmanOwnLeagues($division)) || ($team && $this->ownTeam($user, $division) || $this->ownTeamInParentAssociatedLeague($user, $division)));
    }

    public function ownTeamAndOwnDivision(User $user, Division $division, $team)
    {
        return $team->manager_id === $user->consumer->id &&
                $this->checkIsDivisionTeam($user, $division, $team);
    }

    public function deleteDivsionTeam(User $user, Division $division, $team = null)
    {
        return $this->ownLeagues($user, $division) || ( $team && $user->can('ownTeam', $team) );
    }

    public function accessAuctionSettings(User $user, Division $division)
    {
        return ($this->ownLeagues($user, $division) && ! $division->isPostAuctionState()) ? true : false;  
    }

    public function packageDisabled(User $user, Division $division)
    {
        return ($this->managerHasPaidTeam($user, $division) || $this->isPostAuctionState($user, $division)) ? true : false;
    }

    public function isPostAuctionState(User $user, Division $division)
    {
        return $division->isPostAuctionState();
    }
}
