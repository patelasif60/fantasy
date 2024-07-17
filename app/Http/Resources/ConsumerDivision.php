<?php

namespace App\Http\Resources;

use App\Enums\EuropeanPhasesNameEnum;
use App\Http\Resources\AuctionRound as AuctionRoundResource;
use App\Http\Resources\Consumer as ConsumerResource;
use App\Http\Resources\Package as PackageResource;
use App\Http\Resources\Team as TeamResource;
use App\Models\Fixture;
use App\Models\Season;
use App\Services\CustomCupFixtureService;
use App\Services\DivisionService;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsumerDivision extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user;

        $divisionService = app(DivisionService::class);
        $championLeague = $divisionService->isCompetition($this, $user->consumer->id, EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
        $europaLeague = $divisionService->isCompetition($this, $user->consumer->id, EuropeanPhasesNameEnum::EUROPA_LEAGUE);

        $latestSeason = Season::find(Season::getLatestSeason());
        $season_start = $latestSeason->isSeasonStart();

        return [
            'id' => $this->id,
            'chairman_id' => $this->chairman_id,
            'name' => $this->name,
            'ownLeague' => auth('api')->user()->consumer->ownLeagues($this) || auth('api')->user()->consumer->coChairmanOwnLeagues($this),
            'ownTeam'   => $user->consumer->ownTeamDetails($this),
            'price' => $this->getPrice(),
            'is_preauction_state' => $this->isPreauctionState(),
            'is_inauction_state' => $this->isInAuctionState(),
            'is_paid' => $this->isPaid(),
            'is_auction_closed' => $this->isPostAuctionState(),
            'package_id' => $this->package_id,
            'prize_pack' => $this->prize_pack,
            'introduction' => $this->introduction,
            'parent_division_id' => $this->parent_division_id,
            'auction_types' => $this->getOptionValue('auction_types'),
            'auction_date' => $this->auction_date,
            'pre_season_auction_budget' => $this->getOptionValue('pre_season_auction_budget'),
            'pre_season_auction_bid_increment' => $this->getOptionValue('pre_season_auction_bid_increment'),
            'budget_rollover' => $this->getOptionValue('budget_rollover'),
            'seal_bids_budget' => $this->getOptionValue('seal_bids_budget'),
            'seal_bid_increment' => $this->getOptionValue('seal_bid_increment'),
            'seal_bid_minimum' => $this->getOptionValue('seal_bid_minimum'),
            'manual_bid' => $this->getOptionValue('manual_bid'),
            'first_seal_bid_deadline' => $this->getOptionValue('first_seal_bid_deadline'),
            'seal_bid_deadline_repeat' => $this->getOptionValue('seal_bid_deadline_repeat'),
            'max_seal_bids_per_team_per_round' => $this->getOptionValue('max_seal_bids_per_team_per_round'),
            'money_back' => $this->getOptionValue('money_back'),
            'tie_preference' => $this->getOptionValue('tie_preference'),
            'rules' => $this->rules,
            'default_squad_size' => $this->getOptionValue('default_squad_size'),
            'default_max_player_each_club' => $this->getOptionValue('default_max_player_each_club'),
            'available_formations' => $this->getOptionValue('available_formations'),
            'defensive_midfields' => $this->getOptionValue('defensive_midfields'),
            'merge_defenders' => $this->getOptionValue('merge_defenders'),
            'allow_weekend_changes' => $this->getOptionValue('allow_weekend_changes'),
            'enable_free_agent_transfer' => $this->getOptionValue('enable_free_agent_transfer'),
            'free_agent_transfer_authority' => $this->getOptionValue('free_agent_transfer_authority'),
            'free_agent_transfer_after' => $this->getOptionValue('free_agent_transfer_after'),
            'season_free_agent_transfer_limit' => $this->getOptionValue('season_free_agent_transfer_limit'),
            'monthly_free_agent_transfer_limit' => $this->getOptionValue('monthly_free_agent_transfer_limit'),
            'co_chairman_id' => $this->coChairmen->pluck('id'),
            'co_chairman' => ConsumerResource::collection($this->whenLoaded('coChairmen')),
            'season_start'=> $season_start,
            'package' => new PackageResource($this->whenLoaded('package')),
            'divisionPoints' => DivisionPoint::collection($this->whenLoaded('divisionPoints')),
            'championLeague' => $championLeague,
            'europaLeague' => $europaLeague,
            'europeanCups' => $divisionService->checkEuropeanTournamentAvailable($this),
            'teams' => TeamResource::collection($this->divisionTeams),
            'champions_league_team' => $this->champions_league_team,
            'europa_league_team_1' => $this->europa_league_team_1,
            'europa_league_team_2' => $this->europa_league_team_2,
            'changeNotAllowed' => $divisionService->checkChampionEuropaGameweekStart(),
            'customCups' => app(CustomCupFixtureService::class)->getCustomCups($this, $user->consumer),
            'auctionRounds' => AuctionRoundResource::collection($this->whenLoaded('auctionRounds')),
            'auction_venue' => $this->auction_venue,
            'auction_closing_date' =>  $this->auction_closing_date,
            'allow_passing_on_nominations' =>$this->getOptionValue('allow_passing_on_nominations'),
            'remote_nomination_time_limit' => $this->remote_nomination_time_limit,
            'remote_bidding_time_limit' => $this->remote_bidding_time_limit,
            'allow_managers_to_enter_own_bids' =>  $this->getOptionValue('allow_managers_to_enter_own_bids'),
            'crest' => $this->getDivisionImageThumb(auth('api')->user()),
            'is_league_accessible' => $this->isLeagueAccessible(),
            'managerHasPaidTeam' => $this->isFirstManagerPaid(),
        ];
    }
}
