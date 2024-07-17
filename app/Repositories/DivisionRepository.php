<?php

namespace App\Repositories;

use App\Enums\AuctionTypesEnum;
use App\Enums\CompetitionEnum;
use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\TransferTypeEnum;
use App\Enums\YesNoEnum;
use App\Jobs\OnlineSealedBidsAuctionRoundDeadlineChangedEmail;
use App\Models\AuctionRound;
use App\Models\ChampionEuropaFixture;
use App\Models\ChildLinkedLeague;
use App\Models\Consumer;
use App\Models\Division;
use App\Models\DivisionPoint;
use App\Models\DivisionSubscribers;
use App\Models\DivisionTeam;
use App\Models\EuropeanPhase;
use App\Models\Fixture;
use App\Models\InviteCode;
use App\Models\LeagueTitle;
use App\Models\Package;
use App\Models\ParentLinkedLeague;
use App\Models\Season;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DivisionRepository
{
    const NULL_POINT = 0;
    const UNIQUE_VALUE = 1;

    public function create($data)
    {
        $package = Package::find($data['package_id']);
        $division = Division::create([
            'name' => $data['name'],
            'uuid' => (string) Str::uuid(),
            'chairman_id' => $data['chairman_id'],
            'auctioneer_id' => $data['chairman_id'],
            'package_id' => $data['package_id'],
            'prize_pack' => Arr::get($data, 'prize_pack'),
            'introduction' => Arr::has($data, 'introduction') ? $data['introduction'] : '',
            'parent_division_id' => Arr::has($data, 'parent_division_id') ? $data['parent_division_id'] : null,
            'auction_types' =>  $package->private_league == YesNoEnum::YES ? AuctionTypesEnum::OFFLINE_AUCTION : AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION,
            'tie_preference' =>  $package->private_league == YesNoEnum::YES ? null : TiePreferenceEnum::RANDOMLY_ALLOCATED,
            'is_viewed_package_selection' => Arr::get($data, 'is_viewed_package_selection', 0),
        ]);

        $division->coChairmen()->attach(Arr::get($data, 'co_chairman_id'));

        $events = EventsEnum::toSelectArray();
        $positions = PositionsEnum::toSelectArray();
        $divisionPoint = [];
        foreach ($events as $eventKey => $eventValue) {
            $tempData = [];
            foreach ($positions as $positionKey => $positionValue) {
                $tempData['events'] = $eventKey;
                $tempData[$positionKey] = null;
            }
            array_push($divisionPoint, $tempData);
        }
        $division->divisionPoints()->createMany($divisionPoint);

        return $division;
    }

    public function update($division, $data)
    {
        $division->fill([
            'name' => $data['name'],
            'chairman_id' => $data['chairman_id'],
            'package_id' => $data['package_id'],
            'introduction' => Arr::get($data, 'introduction'),
            'prize_pack' => Arr::get($data, 'prize_pack'),
            'parent_division_id' => Arr::get($data, 'parent_division_id'),
            'auction_types' => Arr::get($data, 'auction_types'),
            'auction_date' =>  ! is_null(Arr::get($data, 'auction_date')) ? $data['auction_date'] : null,
            'pre_season_auction_budget' => Arr::get($data, 'pre_season_auction_budget'),
            'pre_season_auction_bid_increment' => Arr::get($data, 'pre_season_auction_bid_increment'),
            'budget_rollover' =>Arr::get($data, 'budget_rollover'),
            'seal_bids_budget' => Arr::get($data, 'seal_bids_budget'),
            'seal_bid_increment' =>Arr::get($data, 'seal_bid_increment'),
            'seal_bid_minimum' => Arr::get($data, 'seal_bid_minimum'),
            'manual_bid' => Arr::get($data, 'manual_bid'),
            'first_seal_bid_deadline' => ! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? $data['first_seal_bid_deadline'] : null,
            'seal_bid_deadline_repeat' => Arr::get($data, 'seal_bid_deadline_repeat'),
            'max_seal_bids_per_team_per_round' => Arr::get($data, 'max_seal_bids_per_team_per_round'),
            'money_back' => Arr::get($data, 'money_back'),
            'tie_preference' => Arr::get($data, 'tie_preference'),
            'rules' => Arr::get($data, 'rules'),
            'default_squad_size' => Arr::get($data, 'default_squad_size'),
            'default_max_player_each_club' => Arr::get($data, 'default_max_player_each_club'),
            'available_formations' => Arr::has($data, 'available_formations') ? $data['available_formations'] : null,
            'defensive_midfields' => Arr::get($data, 'defensive_midfields'),
            'merge_defenders' => Arr::get($data, 'merge_defenders'),
            'allow_weekend_changes' => Arr::get($data, 'allow_weekend_changes'),
            'enable_free_agent_transfer' => Arr::get($data, 'enable_free_agent_transfer'),
            'free_agent_transfer_authority' => Arr::get($data, 'free_agent_transfer_authority'),
            'free_agent_transfer_after' => Arr::get($data, 'free_agent_transfer_after'),
            'season_free_agent_transfer_limit' => Arr::get($data, 'season_free_agent_transfer_limit'),
            'monthly_free_agent_transfer_limit' => Arr::get($data, 'monthly_free_agent_transfer_limit'),
            // 'champions_league_team' => Arr::get($data, 'champions_league_team', null),
            // 'europa_league_team_1' => Arr::get($data, 'europa_league_team_1', null),
            // 'europa_league_team_2' => Arr::get($data, 'europa_league_team_2', null),
        ]);

        $division->save();
        $division->coChairmen()->sync(Arr::get($data, 'co_chairman_id'));
        if ($division->package->allow_custom_scoring == YesNoEnum::YES) {
            foreach ($data['points'] as $eventKey => $positionValues) {
                $points = [];
                foreach ($positionValues as $positionKey => $positionValue) {
                    $points[$positionKey] = $positionValue;
                }

                $divpoint = DivisionPoint::updateOrCreate(
                    ['division_id' => $division->id, 'events' => $eventKey], $points
                );
            }
        }

        return $division;
    }

    public function updateName($division, $data)
    {
        $division->fill([
            'name' => $data['name'],
        ]);
        $division->save();

        return $division;
    }

    public function updateAuctionDivision($division, $data)
    {
        $division->fill([
            'name' => $data['name'],
            'auction_types' => Arr::get($data, 'auction_types'),
            'auction_date' =>  ! is_null(Arr::get($data, 'auction_date')) ? $data['auction_date'] : null,
            'pre_season_auction_budget' => Arr::get($data, 'pre_season_auction_budget'),
            'pre_season_auction_bid_increment' => Arr::get($data, 'pre_season_auction_bid_increment'),
            'budget_rollover' =>Arr::get($data, 'budget_rollover'),
            'auction_venue' => Arr::get($data, 'auction_venue'),
            'manual_bid' => Arr::get($data, 'auction_types') == 'Online sealed bids' ? Arr::get($data, 'manual_bid') : null,
            'tie_preference' => Arr::get($data, 'tie_preference'),
            'allow_passing_on_nominations' => Arr::get($data, 'auction_types') == 'Live online' ? Arr::get($data, 'allow_passing_on_nominations') : null,
            'remote_nomination_time_limit' => Arr::get($data, 'auction_types') == 'Live online' ? Arr::get($data, 'remote_nomination_time_limit') : null,
            'remote_bidding_time_limit' =>  Arr::get($data, 'auction_types') == 'Live online' ? Arr::get($data, 'allow_passing_on_nominations') == 'Yes' ? Arr::get($data, 'remote_bidding_time_limit') : null : null,
            'allow_managers_to_enter_own_bids' => Arr::get($data, 'auction_types') == 'Live offline' ? Arr::get($data, 'allow_managers_to_enter_own_bids') : null,
            'auctioneer_id' => Arr::get($data, 'auction_types') == 'Live online' ? Arr::get($data, 'auctioneer_id') : null,
        ]);

        $division->save();
        $this->updateRoundsApi($division, $data);

        return $division;
    }

    public function updateDivision($division, $data)
    {
        $division->fill([
            'name' => $data['name'],
            'chairman_id' => Arr::get($data, 'chairman_id'),
            'prize_pack' => Arr::get($data, 'prize_pack'),
            'package_id' => Arr::get($data, 'package_id'),
            'introduction' => Arr::get($data, 'introduction'),
            'parent_division_id' => Arr::get($data, 'parent_division_id'),
            'auction_types' => Arr::get($data, 'auction_types'),
            'auction_date' =>  ! is_null(Arr::get($data, 'auction_date')) ? $data['auction_date'] : null,
            'pre_season_auction_budget' => Arr::get($data, 'pre_season_auction_budget'),
            'pre_season_auction_bid_increment' => Arr::get($data, 'pre_season_auction_bid_increment'),
            'budget_rollover' =>Arr::get($data, 'budget_rollover'),
            'seal_bids_budget' => Arr::get($data, 'seal_bids_budget'),
            'seal_bid_increment' =>Arr::get($data, 'seal_bid_increment'),
            'seal_bid_minimum' => Arr::get($data, 'seal_bid_minimum'),
            'first_seal_bid_deadline' => ! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? $data['first_seal_bid_deadline'] : null,
            'seal_bid_deadline_repeat' => Arr::get($data, 'seal_bid_deadline_repeat'),
            'max_seal_bids_per_team_per_round' => Arr::get($data, 'max_seal_bids_per_team_per_round'),
            'money_back' => Arr::get($data, 'money_back'),
            'tie_preference' => Arr::get($data, 'tie_preference'),
            'rules' => Arr::get($data, 'rules'),
            'default_squad_size' => Arr::get($data, 'default_squad_size'),
            'default_max_player_each_club' => Arr::get($data, 'default_max_player_each_club'),
            'available_formations' => Arr::has($data, 'available_formations') ? $data['available_formations'] : null,
            'defensive_midfields' => Arr::get($data, 'defensive_midfields'),
            'merge_defenders' => Arr::get($data, 'merge_defenders'),
            'allow_weekend_changes' => Arr::get($data, 'allow_weekend_changes'),
            'enable_free_agent_transfer' => Arr::get($data, 'enable_free_agent_transfer'),
            'free_agent_transfer_authority' => Arr::get($data, 'free_agent_transfer_authority'),
            'free_agent_transfer_after' => Arr::get($data, 'free_agent_transfer_after'),
            'season_free_agent_transfer_limit' => Arr::get($data, 'season_free_agent_transfer_limit'),
            'monthly_free_agent_transfer_limit' => Arr::get($data, 'monthly_free_agent_transfer_limit'),
            'manual_bid' => Arr::get($data, 'auction_types') == 'Online sealed bids' ? Arr::get($data, 'manual_bid') : null,
        ]);
        $division->save();
        $division->coChairmen()->sync(Arr::get($data, 'co_chairman_id'));

        return $division;
    }

    public function getConsumers()
    {
        return Consumer::join('users', 'users.id', '=', 'consumers.user_id')
            ->select('consumers.id', 'users.first_name', 'users.last_name', 'users.email')
            ->orderBy('users.first_name')
            ->get();
    }

    public function getChairman($division)
    {
        return Consumer::join('users', 'users.id', '=', 'consumers.user_id')
            ->select('consumers.id', 'users.first_name', 'users.last_name', 'users.email')
            ->where('consumers.id', $division->chairman_id)
            ->get();
    }

    public function getCoChairmen($division)
    {
        $coChairmens = $division->coChairmen->pluck('id');
        if ($coChairmens) {
            $coChairmens = $coChairmens->toArray();

            return Consumer::join('users', 'users.id', '=', 'consumers.user_id')
                ->select('consumers.id', 'users.first_name', 'users.last_name', 'users.email')
                ->whereIn('consumers.id', $coChairmens)
                ->get();
        }

        return [];
    }

    public function getDivisions($season)
    {
        return Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
            ->where('division_teams.season_id', $season)
            ->whereNull('divisions.parent_division_id')
            ->orderBy('divisions.name')
            ->pluck('divisions.name', 'divisions.id');

        // return Division::active()->orderBy('name')->pluck('name', 'id');
    }

    public function getSeasons()
    {
        return Season::orderBy('id', 'desc')->pluck('name', 'id')->all();
    }

    public function getInvitationDetails($code)
    {
        return InviteCode::with(['division', 'user'])->where('code', $code)->first();
    }

    public function joinDivision($data)
    {
        if (isset($data['invitation_code']) && $data['invitation_code'] != '') {
            $invitation = InviteCode::where('code', $data['invitation_code'])->first();
            $divisionId = $invitation->division_id;
        } else {
            $divisionId = $data['division_id'];
        }

        //check user entry
        $chkCount = DivisionSubscribers::where('user_id', Auth::user()->id)
                                        ->where('division_id', $divisionId)
                                        ->count();
        if ($chkCount == 0) {
            $subscriber = DivisionSubscribers::create([
                'division_id' => $divisionId,
                'user_id' => Auth::user()->id,
            ]);

            return $subscriber;
        } else {
            return false;
        }
    }

    public function getConsumerDivisions()
    {
        $chairman_id = Auth::user()->consumer->id;

        return Division::where('chairman_id', $chairman_id)->pluck('name', 'id');
    }

    public function validateLeagueName($league_name)
    {
        // $division = Division::where('name', $league_name);

        // if ($division->count() === 0) {
        $filter = app('profanityFilter')->filter($league_name);
        if ($filter != $league_name) {
            return 'false';
        }

        return 'true';
        // }

        // return 'false';
    }

    public function getPreviousSeasonDivisonCount()
    {
        return Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
            ->where('division_teams.season_id', Season::getPreviousSeason())
            ->count();
    }

    /**
     * Note change seasons to previous once data are perfect
     * This is only for testing purpose now.
     * Use Season::getPreviousSeason()
     * instead of Season::getLatestSeason().
     */
    public function checkEuropeanTournamentAvailable($division)
    {
        $divisions = $this->getSameNameDivisions($division->uuid);

        $divisions = Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
            ->whereIn('division_teams.division_id', $divisions)
            ->where('division_teams.season_id', Season::getPreviousSeason())
            ->select('season_id')
            ->count();

        if ($divisions) {
            return true;
        }

        return false;
    }

    public function updateDivisionsLeague($division, $data)
    {
        $division->fill([
            'name' => $data['name'],
            'package_id' => Arr::has($data, 'package_id') ? auth()->user()->cannot('packageDisabled', $division) ? $data['package_id'] : $division->package_id : $division->package_id,
            'chairman_id' => $data['chairman_id'],
            'introduction' => Arr::get($data, 'introduction'),
        ]);

        $division->save();
        $division->coChairmen()->sync(Arr::get($data, 'co_chairman_id'));

        return $division;
    }

    public function updateDivisionsAuction($division, $data)
    {
        $pre_season_auction_bid_increment = $division->pre_season_auction_bid_increment;
        if (Arr::get($data, 'pre_season_auction_bid_increment') || Arr::get($data, 'pre_season_auction_bid_increment') == 0) {
            if ($division->package->allow_bid_increment == 'Yes' && isset($data['pre_season_auction_bid_increment'])) {
                $pre_season_auction_bid_increment = $data['pre_season_auction_bid_increment'];
            }
        }

        $division->fill([
            'pre_season_auction_budget' => Arr::get($data, 'pre_season_auction_budget') ? $division->package->allow_auction_budget == 'Yes' ? $data['pre_season_auction_budget'] : $division->pre_season_auction_budget : $division->pre_season_auction_budget,
            'pre_season_auction_bid_increment' => $pre_season_auction_bid_increment,
            'auction_types' => Arr::get($data, 'auction_types'),
            'auction_date' =>  ! is_null(Arr::get($data, 'auction_date')) ? $data['auction_date'] : null,
            'budget_rollover' => Arr::get($data, 'budget_rollover') ? $division->package->allow_rollover_budget == 'Yes' ? $data['budget_rollover'] : $division->budget_rollover : $division->budget_rollover,
            'auction_venue' => (Arr::get($data, 'auction_venue') && Arr::get($data, 'auction_types') != AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) ? $data['auction_venue'] : null,
            'auctioneer_id' => Arr::get($data, 'auction_types') == AuctionTypesEnum::LIVE_ONLINE_AUCTION ? Arr::get($data, 'auctioneer', $division->auctioneer_id) : $division->auctioneer_id,
            'allow_passing_on_nominations' => Arr::get($data, 'auction_types') == AuctionTypesEnum::LIVE_ONLINE_AUCTION ? Arr::get($data, 'allow_passing_on_nominations') : null,
            'remote_nomination_time_limit' => Arr::get($data, 'auction_types') == AuctionTypesEnum::LIVE_ONLINE_AUCTION ? Arr::get($data, 'remote_nomination_time_limit') : null,
            'remote_bidding_time_limit' =>  Arr::get($data, 'auction_types') == AuctionTypesEnum::LIVE_ONLINE_AUCTION ? Arr::get($data, 'allow_passing_on_nominations') == 'Yes' ? Arr::get($data, 'remote_bidding_time_limit') : null : null,
            'manual_bid' => Arr::get($data, 'auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION ? array_get($data, 'manual_bid') : null,
            'tie_preference' => Arr::get($data, 'tie_preference') ? $data['tie_preference'] : $division->tie_preference,
            'allow_managers_to_enter_own_bids' => Arr::get($data, 'auction_types') == AuctionTypesEnum::OFFLINE_AUCTION ? Arr::get($data, 'allow_managers_to_enter_own_bids') ? $data['allow_managers_to_enter_own_bids'] : $division->tie_preference : null,
        ]);
        $division->save();

        if (Arr::has($data, 'pre_season_auction_budget')) {
            $divisionTeamsId = $division->divisionTeams->pluck('id');
            Team::whereIn('id', $divisionTeamsId)
            ->update(['team_budget' => $data['pre_season_auction_budget']]);
        }

        $this->updateRounds($division, $data);

        return $division;
    }

    public function updateRoundsApi($division, $data)
    {
        if (array_get($data, 'auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            foreach ($data['auctionRounds'] as $auctionRoundsKey => $auctionRoundsVal) {
                if ($auctionRoundsVal['end']) {
                    if (isset($auctionRoundsVal['id'])) {
                        AuctionRound::where('id', $auctionRoundsVal['id'])
                        ->update(['start' => $auctionRoundsVal['start'], 'end' => $auctionRoundsVal['end']]);
                    } else {
                        AuctionRound::create([
                            'division_id' => $division->id,
                            'start' => $auctionRoundsVal['start'],
                            'end' => $auctionRoundsVal['end'],
                            'number'=>$auctionRoundsVal['number'],
                        ]);
                    }
                }
            }
        } else {
            AuctionRound::where('division_id', $division->id)->delete();
        }
    }

    public function updateRounds($division, $data)
    {
        $count = intval(AuctionRound::where('division_id', $division->id)->max('number'));
        if (Arr::get($data, 'auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            foreach ($data['round_end_date'] as $roundDateKeys => $roundDateValues) {
                foreach ($roundDateValues as $roundDateKey=>$roundDateVal) {
                    if ($roundDateVal) {
                        if ($roundDateKey > 0) {
                            $auctiondbdata = AuctionRound::find($roundDateKey);

                            $start = isset($startDate) ? $startDate : carbon_set_db_date_time($data['round_start_date'][$roundDateKey].' '.$data['round_start_time'][$roundDateKey]);
                            $end = carbon_set_db_date_time($roundDateVal.' '.$data['round_end_time'][$roundDateKeys][$roundDateKey]);

                            if ($auctiondbdata->is_process != 'P') {
                                if (($auctiondbdata->start != $start) || ($auctiondbdata->end != $end)) {
                                    OnlineSealedBidsAuctionRoundDeadlineChangedEmail::dispatch($division);
                                }

                                AuctionRound::where('id', $roundDateKey)->update(['start' => $start, 'end' => $end]);
                            }
                        } else {
                            $count++;
                            AuctionRound::create([
                                'division_id' => $division->id,
                                'start' => isset($startDate) ? $startDate :  carbon_set_db_date_time($data['round_start_date'][$roundDateKey].' '.$data['round_start_time'][$roundDateKey]),
                                'end' => carbon_set_db_date_time($roundDateVal.' '.$data['round_end_time'][$roundDateKeys][$roundDateKey]),
                                'number'=> $count,
                            ]);
                        }
                        $startDate = carbon_set_db_date_time($roundDateVal.' '.$data['round_end_time'][$roundDateKeys][$roundDateKey]);
                    }
                }
            }
        } else {
            AuctionRound::where('division_id', $division->id)->delete();
        }
    }

    public function updateDivisionsSealedBids($division, $data)
    {
        $division->fill([
            'seal_bids_budget' => Arr::get($data, 'seal_bids_budget'),
            'seal_bid_increment' => Arr::get($data, 'seal_bid_increment'),
            'seal_bid_minimum' => Arr::get($data, 'seal_bid_minimum'),
            'manual_bid' => Arr::get($data, 'manual_bid'),
            'first_seal_bid_deadline' => ! is_null(Arr::get($data, 'first_seal_bid_deadline')) ? $data['first_seal_bid_deadline'] : null,
            'seal_bid_deadline_repeat' => Arr::get($data, 'seal_bid_deadline_repeat') ? $division->package->allow_seal_bid_deadline_repeat == 'Yes' ? $data['seal_bid_deadline_repeat'] : $division->seal_bid_deadline_repeat : $division->seal_bid_deadline_repeat,
            'max_seal_bids_per_team_per_round' => Arr::get($data, 'max_seal_bids_per_team_per_round'),
            'money_back' => Arr::get($data, 'money_back'),
            'tie_preference' => Arr::get($data, 'tie_preference'),
            'rules' => Arr::get($data, 'rules'),
        ]);

        $division->save();

        return $division;
    }

    public function updateDivisionsSquadAndFormations($division, $data)
    {
        $division->fill([
            'default_squad_size' => Arr::get($data, 'default_squad_size') ? $division->package->custom_squad_size == 'Yes' ? $data['default_squad_size'] : $division->default_squad_size : $division->default_squad_size,
            'default_max_player_each_club' => Arr::get($data, 'default_max_player_each_club') ? $division->package->custom_club_quota == 'Yes' ? $data['default_max_player_each_club'] : $division->default_max_player_each_club : $division->default_max_player_each_club,
            'available_formations' => Arr::has($data, 'available_formations') ? $division->package->allow_available_formations == 'Yes' ? $data['available_formations'] : $division->available_formations : $division->available_formations,
            'defensive_midfields' => Arr::get($data, 'defensive_midfields') ? $division->package->allow_defensive_midfielders == 'Yes' ? $data['defensive_midfields'] : $division->defensive_midfields : $division->defensive_midfields,
            'merge_defenders' => Arr::get($data, 'merge_defenders') ? $division->package->allow_merge_defenders == 'Yes' ? $data['merge_defenders'] : $division->merge_defenders : $division->merge_defenders,
            'allow_weekend_changes' => Arr::get($data, 'allow_weekend_changes') ? $division->package->allow_weekend_changes_editable == 'Yes' ? $data['allow_weekend_changes'] : $division->allow_weekend_changes : $division->allow_weekend_changes,
        ]);

        $division->save();

        return $division;
    }

    public function updateDivisionsTransfer($division, $data)
    {
        $division->fill([
            'seal_bids_budget' => $division->package->allow_season_budget == 'Yes' ? Arr::get($data, 'seal_bids_budget') : $division->seal_bids_budget,
            'enable_free_agent_transfer' => Arr::get($data, 'enable_free_agent_transfer'),
            'free_agent_transfer_authority' => Arr::get($data, 'free_agent_transfer_authority') ? $division->package->allow_free_agent_transfer_authority == 'Yes' ? $data['free_agent_transfer_authority'] : $division->free_agent_transfer_authority : $division->free_agent_transfer_authority,
            'free_agent_transfer_after' => Arr::get($data, 'free_agent_transfer_after'),
            'season_free_agent_transfer_limit' => Arr::get($data, 'season_free_agent_transfer_limit') ? $division->package->allow_season_free_agent_transfer_limit == 'Yes' ? $data['season_free_agent_transfer_limit'] : $division->season_free_agent_transfer_limit : $division->season_free_agent_transfer_limit,
            'monthly_free_agent_transfer_limit' => Arr::get($data, 'monthly_free_agent_transfer_limit') ? $division->package->allow_monthly_free_agent_transfer_limit == 'Yes' ? $data['monthly_free_agent_transfer_limit'] : $division->monthly_free_agent_transfer_limit : $division->monthly_free_agent_transfer_limit,
            'seal_bid_increment' => Arr::get($data, 'seal_bid_increment'),
            'seal_bid_minimum' => Arr::get($data, 'seal_bid_minimum'),
            'seal_bid_deadline_repeat' => ! $division->isPostAuctionState() ? $division->seal_bid_deadline_repeat : Arr::get($data, 'seal_bid_deadline_repeat') ? $division->package->allow_seal_bid_deadline_repeat == 'Yes' ? $data['seal_bid_deadline_repeat'] : $division->seal_bid_deadline_repeat : $division->seal_bid_deadline_repeat,
            'money_back' => Arr::get($data, 'money_back'),
            'tie_preference' => ! $division->isPostAuctionState() ? $division->tie_preference : Arr::get($data, 'tie_preference'),
            'max_seal_bids_per_team_per_round' => $division->package->allow_max_bids_per_round == 'Yes' ? Arr::get($data, 'max_seal_bids_per_team_per_round') : $division->max_seal_bids_per_team_per_round,
        ]);

        $division->save();

        return $division;
    }

    public function updateDivisionsEuropeanCups($division, $data)
    {
        $division->fill([
            'champions_league_team' => Arr::get($data, 'champions_league_team'),
            'europa_league_team_1' => Arr::get($data, 'europa_league_team_1'),
            'europa_league_team_2' => Arr::get($data, 'europa_league_team_2'),
        ]);

        $division->save();

        return $division;
    }

    public function getDivisionPlayers($division, $data, $forPDF = false)
    {
        $query = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
            ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('packages', 'packages.id', '=', 'divisions.package_id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts', 'players.id', '=', 'player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('team_player_points', function ($join) {
                $join->on('players.id', '=', 'team_player_points.player_id');
                $join->on('teams.id', '=', 'team_player_points.team_id');
            })
            ->leftJoin('transfers', function ($join) {
                $join->on('transfers.player_in', '=', 'team_player_contracts.player_id');
                $join->on('teams.id', '=', 'transfers.team_id');
                $join->where('transfers.transfer_type', '=', TransferTypeEnum::SEALEDBIDS);
            })
            ->selectRaw('team_player_points.team_id,team_player_points.player_id,player_contracts.position,players.first_name as player_first_name,players.last_name as player_last_name,users.first_name as user_first_name,users.last_name as user_last_name,clubs.name as club_name,clubs.short_code as club_short,teams.name as team_name,transfers.transfer_value,divisions.merge_defenders as division_merge_defenders,packages.merge_defenders as package_merge_defenders,sum(team_player_points.goal) goal,sum(team_player_points.assist) assist,sum(team_player_points.clean_sheet) clean_sheet,sum(team_player_points.conceded) conceded,sum(team_player_points.appearance) appearance,sum(team_player_points.total) total')
            ->where('divisions.id', $division)
            ->whereNull('team_player_contracts.end_date')
            ->orderByRaw("FIELD(player_contracts.position, 'Goalkeeper (GK)','Full-back (FB)','Centre-back (CB)','Defensive Midfielder (DMF)','Midfielder (MF)','Striker (ST)')")
            ->groupBy('team_player_points.team_id', 'team_player_points.player_id', 'player_contracts.position', 'players.first_name', 'players.last_name', 'users.first_name', 'users.last_name', 'clubs.name', 'teams.name', 'transfers.transfer_value', 'divisions.merge_defenders', 'packages.merge_defenders', 'clubs.short_code');

        if (Arr::has($data, 'position')) {
            $query->where('player_contracts.position', 'like', '%'.escape_like($data['position']).'%');
        }

        if (Arr::has($data, 'club_id')) {
            $query->where('clubs.id', $data['club_id']);
        }

        if ($forPDF) {
            $query->orderByDesc('total');

            if (Arr::has($data, 'startDate')) {
                $query->where('team_player_points.created_at', '>=', $data['startDate']);
            }
            if (Arr::has($data, 'endDate')) {
                $query->where('team_player_points.created_at', '<=', $data['endDate']);
            }

            return $query->get();
        }

        return $query->paginate(3);
    }

    public function getDivisionTeamPlayers($division, $team)
    {
        $query = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
            ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('packages', 'packages.id', '=', 'divisions.package_id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts', 'players.id', '=', 'player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('team_player_points', function ($join) {
                $join->on('players.id', '=', 'team_player_points.player_id');
                $join->on('teams.id', '=', 'team_player_points.team_id');
            })
            ->leftJoin('transfers', function ($join) {
                $join->on('transfers.player_in', '=', 'team_player_contracts.player_id');
                $join->on('teams.id', '=', 'transfers.team_id');
                $join->where('transfers.transfer_type', '=', TransferTypeEnum::SEALEDBIDS);
            })
            ->selectRaw('team_player_points.team_id,team_player_points.player_id,player_contracts.position,players.first_name as player_first_name,players.last_name as player_last_name,users.first_name as user_first_name,users.last_name as user_last_name,clubs.name as club_name,teams.name as team_name,transfers.transfer_value,divisions.merge_defenders as division_merge_defenders,packages.merge_defenders as package_merge_defenders,sum(team_player_points.goal) goal,sum(team_player_points.assist) assist,sum(team_player_points.clean_sheet) clean_sheet,sum(team_player_points.conceded) conceded,sum(team_player_points.appearance) appearance,sum(team_player_points.total) total')
            ->whereNull('team_player_contracts.end_date')
            ->orderByRaw("FIELD(player_contracts.position, 'Goalkeeper (GK)','Full-back (FB)','Centre-back (CB)','Defensive Midfielder (DMF)','Midfielder (MF)','Striker (ST)')")
            ->orderBy('players.first_name')
            ->groupBy('team_player_points.team_id', 'team_player_points.player_id', 'player_contracts.position', 'players.first_name', 'players.last_name', 'users.first_name', 'users.last_name', 'clubs.name', 'teams.name', 'transfers.transfer_value', 'divisions.merge_defenders', 'packages.merge_defenders');

        return $query->where('team_player_contracts.team_id', $team)->get();
    }

    public function getDivisionLeagueStandingsTeamsScores($division, $data)
    {
        if (Arr::has($data, 'startDate') && Arr::has($data, 'endDate')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $data['startDate'])->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $data['endDate']);
            $endDate = Arr::has($data, 'filter') && Arr::get($data, 'filter') == 'month' ? $endDate->endOfDay() : $endDate->startOfDay();
        } else {
            $season = Season::find(Season::getLatestSeason());
            $startDate = $season->start_at->startOfDay();
            $endDate = $season->end_at->endOfDay();
        }

        if (Arr::has($data, 'linkedLeague')) {
            $divisions = ChildLinkedLeague::where('parent_linked_league_id', $data['linkedLeague'])->pluck('division_id')->toArray();

            $divisions[] = ParentLinkedLeague::find($data['linkedLeague'])->division_id;
        }

        $divisions[] = $division->id;
        $divisions = array_unique($divisions);

        $competition = CompetitionEnum::PREMIER_LEAGUE;

        $contractStart = now();

        $divisionTeams = Division::leftJoin('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->leftJoin(
                DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id INNER JOIN team_player_points ON team_player_points.`team_point_id` = team_points.`id`
                    AND fixtures.date_time >= '$startDate' AND fixtures.date_time < '$endDate' AND fixtures.competition = '$competition')"),
                function ($join) {
                    $join->on('team_points.team_id', '=', 'division_teams.team_id');
                }
            )
            ->leftJoin('player_contracts as latest_player_contracts', function ($join) use ($contractStart) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = team_player_points.player_id AND ((( '".$contractStart."' >= player_contracts.start_date AND '".$contractStart."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$contractStart."'))limit 1)"));
            })
            ->leftJoin('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->select(
                'player_contracts.position as position',
                'teams.name as teamName',
                'teams.id as teamId',
                'division_teams.division_id as divisionId',
                'team_player_points.goal as total_goal',
                'team_player_points.assist as total_assist',
                'team_player_points.clean_sheet as total_clean_sheet',
                'team_player_points.conceded as total_conceded',
                'team_player_points.appearance as total_appearance',
                'team_player_points.own_goal as total_own_goal',
                'team_player_points.red_card as total_red_card',
                'team_player_points.yellow_card as total_yellow_card',
                'team_player_points.penalty_missed as total_penalty_missed',
                'team_player_points.penalty_saved as total_penalty_saved',
                'team_player_points.goalkeeper_save as total_goalkeeper_save',
                'team_player_points.club_win as total_club_win',
                'team_player_points.total as total_point',
                'users.first_name',
                'users.last_name',
                'users.email as manager_email'
            )
            ->whereIn('divisions.id', $divisions)
            ->where('teams.is_approved', true);

        if (Arr::has($data, 'team')) {
            $divisionTeams = $divisionTeams->where('teams.id', Arr::get($data, 'team'));
        }

        return $divisionTeams->get();
    }

    public function getPointAdjustments($division)
    {
        $pointAdjustments = \App\Models\PointAdjustment::join('division_teams', 'division_teams.team_id', 'point_adjustments.team_id')
                                            ->where('division_teams.division_id', $division->id)
                                            ->where('point_adjustments.season_id', Season::getLatestSeason())
                                            ->selectRaw('point_adjustments.team_id, point_adjustments.competition_type, SUM(point_adjustments.points) AS points')
                                            ->groupBy('point_adjustments.team_id', 'point_adjustments.competition_type')
                                            ->get();

        $adjustments = [];
        foreach ($pointAdjustments as $adjustment) {
            $adjustments[$adjustment->team_id][$adjustment->competition_type] = $adjustment->points;
        }

        return $adjustments;
    }

    public function getLeagueTitle($division)
    {
        $divisionIds = $division->getDivisionFromUuid();

        return LeagueTitle::whereIn('division_id', $divisionIds)->select('titles', 'team_id', DB::raw('LOWER(TRIM(name)) as name'))->get();
    }

    public function getDivisionLeagueStandingsTeamsScoresDateWise($division, $data)
    {
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];

        $competition = CompetitionEnum::PREMIER_LEAGUE;

        $divisionTeams = Division::leftJoin('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id')
            ->leftJoin(
                DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id INNER JOIN team_player_points ON team_player_points.`team_point_id` = team_points.`id` AND fixtures.date_time >= '$startDate' AND fixtures.date_time < '$endDate' AND fixtures.competition = '$competition')"),
                function ($join) {
                    $join->on('team_points.team_id', '=', 'division_teams.team_id');
                }
            )
            ->select(
                'teams.id as teamId',
                DB::raw('SUM(team_player_points.total) as total_point,SUM(team_player_points.goal) as total_goal,SUM(team_player_points.assist) as total_assist')
            )
            ->whereIn('divisions.id', $division)
            ->where('teams.is_approved', true)
            ->orderBy('total_point', 'desc')
            ->orderBy('total_goal', 'desc')
            ->orderBy('total_assist', 'desc');

        return $divisionTeams->groupBy('teamId')->get();
    }

    public function getDivisionFaCupTeamsScores($division, $data)
    {
        $season = Season::find(Season::getLatestSeason());
        $startDate = $season->start_at->format('Y-m-d');
        $endDate = $season->end_at->format('Y-m-d');

        $competition = CompetitionEnum::FA_CUP;

        $divisionTeams = Division::leftJoin('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id');

        if (Arr::has($data, 'round')) {
            $round = $data['round'];
            $divisionTeams = $divisionTeams->leftJoin(
                DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id AND DATE(fixtures.date_time) >= '$startDate' AND DATE(fixtures.date_time) <= '$endDate' AND fixtures.competition = '$competition' AND fixtures.stage = '$round' )"),
                function ($join) {
                    $join->on('team_points.team_id', '=', 'division_teams.team_id');
                }
            );
        } else {
            $prevDataPoints = $this->getDivisionRoundFaCupTeamsScores($division, $data);

            $divisionTeams = $divisionTeams->leftJoin(
                DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id AND DATE(fixtures.date_time) >= '$startDate' AND DATE(fixtures.date_time) <= '$endDate' AND fixtures.competition = '$competition')"),
                function ($join) {
                    $join->on('team_points.team_id', '=', 'division_teams.team_id');
                }
            );
        }
        $divisionTeams = $divisionTeams->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->select(
                'teams.name as teamName',
                'teams.id as teamId',
                DB::raw('SUM(team_points.goal) as total_goal'),
                DB::raw('SUM(team_points.appearance) as total_appearance'),
                DB::raw('SUM(team_points.assist) as total_assist'),
                DB::raw('SUM(team_points.clean_sheet) as total_clean_sheet'),
                DB::raw('SUM(team_points.conceded) as total_conceded'),
                DB::raw('SUM(team_points.own_goal) as own_goal'),
                DB::raw('SUM(team_points.red_card) as red_card'),
                DB::raw('SUM(team_points.yellow_card) as yellow_card'),
                DB::raw('SUM(team_points.penalty_missed) as penalty_missed'),
                DB::raw('SUM(team_points.penalty_saved) as penalty_saved'),
                DB::raw('SUM(team_points.goalkeeper_save) as goalkeeper_save'),
                DB::raw('SUM(team_points.club_win) as club_win'),
                DB::raw('SUM(team_points.total) as total_point'),
                'users.first_name',
                'users.last_name'
            )
            ->where('divisions.id', $division->id)
            ->where('teams.is_approved', true);

        if (Arr::has($data, 'team')) {
            $divisionTeams = $divisionTeams->where('teams.id', Arr::get($data, 'team'));
        }

        $divisionTeams = $divisionTeams->orderBy('total_point', 'desc')
            ->groupBy('teams.id')
            ->get();

        $allTeams = array_column($divisionTeams->toArray(), 'teamId');

        $position = 0;
        foreach ($divisionTeams as $key => $value) {
            if ($value->total_point == null) {
                $value->total_point = 0;
            }

            $totalPoints = $value->total_point;
            if ($key == 0 || $totalPoints != $divisionTeams[$key - 1]->total_point) {
                $position++;
            }
            $divisionTeams[$key]->league_position = $position;
            $divisionTeams[$key]->round_total = @$prevDataPoints[$value->teamId]->total_point;
        }

        $allTeams = $this->getTeamsById($allTeams);
        $divisionTeams = collect($divisionTeams)->map(function ($value, $key) use ($allTeams) {
            $team = $allTeams->where('id', $value['teamId'])->first();
            $value['crest'] = $team->getCrestImageThumb();

            return $value;
        });

        $divisionTeams = $divisionTeams->toArray();

        array_multisort(array_column($divisionTeams, 'total_point'), SORT_DESC,
                        array_column($divisionTeams, 'total_goal'),      SORT_DESC,
                        array_column($divisionTeams, 'total_assist'),      SORT_DESC,
                        $divisionTeams);

        $position = 0;

        foreach ($divisionTeams as $key => $value) {
            $totalGoal = $value['total_goal'];
            $totalAssist = $value['total_assist'];
            $totalPoints = $value['total_point'];

            $prevGoal = $prevAssist = $prevPoints = 0;

            if ($key > 0) {
                $prev = $divisionTeams[$key - 1];
                $prevGoal = $prev['total_goal'];
                $prevAssist = $prev['total_assist'];
                $prevPoints = $prev['total_point'];
            }

            if ($key == 0) {
                $position = $key + 1;
            } else {
                if ($totalPoints != $prevPoints) {
                    $position = $key + 1;
                } elseif ($totalGoal != $prevGoal) {
                    $position = $key + 1;
                } elseif ($totalAssist != $prevAssist) {
                    $position = $key + 1;
                }
            }

            $divisionTeams[$key]['league_position'] = $position;
        }

        return $divisionTeams;
    }

    public function getDivisionRoundFaCupTeamsScores($division, $data)
    {
        $today = Carbon::now()->format('Y-m-d');
        $cupRound = Fixture::where('competition', 'FA Cup')
                            ->where('season_id', Season::getLatestSeason())
                            ->where(DB::raw('CONVERT(fixtures.date_time, DATE)'), '<=', $today)
                            ->select('stage')
                            ->orderBy('id', 'desc')
                            ->first();

        if (! empty($cupRound)) {
            $cupRound = $cupRound->stage;
        } else {
            $cupRound = '3rd Round';
        }

        $season = Season::find(Season::getLatestSeason());
        $startDate = $season->start_at->format('Y-m-d');
        $endDate = $season->end_at->format('Y-m-d');

        $competition = CompetitionEnum::FA_CUP;

        $divisionTeams = Division::leftJoin('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'teams.id', '=', 'division_teams.team_id');

        $divisionTeams = $divisionTeams->leftJoin(
            DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id AND DATE(fixtures.date_time) >= '$startDate' AND DATE(fixtures.date_time) <= '$endDate' AND fixtures.competition = '$competition' AND fixtures.stage = '$cupRound')"),
            function ($join) {
                $join->on('team_points.team_id', '=', 'division_teams.team_id');
            }
        );

        $divisionTeams = $divisionTeams
            ->select(
                'teams.id as teamId',
                DB::raw('SUM(team_points.total) as total_point')
            )
            ->where('divisions.id', $division->id)
            ->where('teams.is_approved', true);

        if (Arr::has($data, 'team')) {
            $divisionTeams = $divisionTeams->where('teams.id', Arr::get($data, 'team'));
        }

        $divisionTeams = $divisionTeams->orderBy('total_point', 'desc')
            ->groupBy('teams.id')
            ->get()->keyBy('teamId');

        return $divisionTeams;
    }

    public function getUserLeagues($user)
    {
        return $user->consumer->ownDivisionWithRegisterTeam();
    }

    public function updateDivisionsPoints($division, $data)
    {
        if ($division->package->allow_custom_scoring == YesNoEnum::YES) {
            foreach ($data['points'] as $eventKey => $positionValues) {
                foreach ($positionValues as $positionKey => $positionValue) {
                    DivisionPoint::where('division_id', $division->id)
                      ->where('events', $eventKey)
                      ->update([$positionKey => $positionValue]);
                }
            }
        }

        return $division;
    }

    public function updateDivisionPoint($divisionPoint, $data)
    {
        $divisionPoint->save();

        return $divisionPoint;
    }

    public function teamApprovals($division)
    {
        return $division->divisionTeams
                        ->where('is_approved', 0)
                        ->where('is_ignored', 0);
    }

    public function getTeamsScores($data)
    {
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $teamIds = $data['teams'];
        $season = Season::getLatestSeason();
        $competition = CompetitionEnum::PREMIER_LEAGUE;

        $divisionTeams = DivisionTeam::join('teams', 'teams.id', '=', 'division_teams.team_id')
        ->leftJoin(
            DB::raw("(team_points INNER JOIN fixtures ON fixtures.id = team_points.fixture_id AND fixtures.date_time >= '$startDate' AND fixtures.date_time < '$endDate' AND fixtures.competition = '$competition' AND fixtures.season_id = $season)"),
            function ($join) {
                $join->on('team_points.team_id', '=', 'division_teams.team_id');
            }
        )
        ->select(
            'teams.name as teamName',
            'teams.id as teamId',
            DB::raw('COALESCE(SUM(team_points.goal),0) as total_goal'),
            DB::raw('COALESCE(SUM(team_points.assist),0) as total_assist'),
            DB::raw('COALESCE(SUM(team_points.clean_sheet),0) as total_clean_sheet'),
            DB::raw('COALESCE(SUM(team_points.conceded),0) as total_conceded'),
            DB::raw('COALESCE(SUM(team_points.total),0) as total_point')
        )
        ->where('teams.is_approved', true)
        ->whereIn('teams.id', $teamIds)
        ->orderBy('total_point', 'desc')
        ->groupBy('teams.id')
        ->get();

        return $divisionTeams;
    }

    public function isCompetition($division, $consumer, $tournament)
    {
        $teams = DivisionTeam::where('division_id', $division->id)->pluck('team_id');
        $champion = EuropeanPhase::join('champion_europa_fixtures', 'champion_europa_fixtures.european_phase_id', '=', 'european_phases.id')
            ->join('teams', function ($join) {
                $join->on('champion_europa_fixtures.home', 'teams.id');
                $join->orOn('champion_europa_fixtures.away', 'teams.id');
            })
            ->join('division_teams', 'teams.id', '=', 'division_teams.team_id')
            ->join('gameweeks', 'european_phases.gameweek_id', '=', 'gameweeks.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('divisions.id', '=', $division->id)
            ->where(function ($query) use ($consumer) {
                $query->where('teams.manager_id', '=', $consumer)
                      ->orWhere('divisions.chairman_id', '=', $consumer);
            })
            ->where('champion_europa_fixtures.tournament_type', '=', $tournament)
            ->select('european_phases.id', 'european_phases.name', 'champion_europa_fixtures.group_no', 'gameweeks.start', 'gameweeks.end')
            ->groupBy('european_phases.id', 'european_phases.name', 'champion_europa_fixtures.group_no')
            ->get();

        return count($champion);
    }

    public function checkChampionEuropaGameweekStart()
    {
        $start = ChampionEuropaFixture::where('season_id', Season::getLatestSeason())->count();

        if ($start) {
            return true;
        }

        return false;
    }

    public function getSameNameDivisions($uuid)
    {
        return Division::where('uuid', $uuid)->pluck('id');
    }

    public function getDivisionTopTeams($season)
    {
        return Division::select(DB::raw('winner.division_id, winner.team_id,winner.points,winner.goal,winner.assist,winner.name'))
            ->from(DB::raw('(SELECT division_teams.division_id,division_teams.team_id,SUM(team_points.total) AS points,SUM(team_points.goal) AS goal,SUM(team_points.assist) AS assist,teams.name FROM seasons INNER JOIN division_teams ON division_teams.season_id = seasons.id INNER JOIN teams ON division_teams.team_id = teams.id INNER JOIN team_points ON team_points.team_id = division_teams.team_id
                    WHERE seasons.id = '.$season.' GROUP BY division_teams.division_id,team_points.team_id
                    ) winner'))
            ->leftJoin(
                DB::raw('(SELECT division_teams.division_id,division_teams.team_id,SUM(team_points.total) AS points,SUM(team_points.goal) AS goal,SUM(team_points.assist) AS assist,teams.name FROM seasons INNER JOIN division_teams ON division_teams.season_id = seasons.id INNER JOIN teams ON division_teams.team_id = teams.id INNER JOIN team_points ON team_points.team_id = division_teams.team_id
                    WHERE seasons.id = '.$season.' GROUP BY division_teams.division_id,team_points.team_id
                    ) AS runner'),
                function ($join) {
                    $join->on('winner.division_id', '=', 'runner.division_id');
                    $join->on('winner.points', '<', 'runner.points');
                }
            )
            ->orderBy('winner.division_id')
            ->orderBy('winner.points', 'desc')
            ->orderBy('winner.goal', 'desc')
            ->orderBy('winner.assist', 'desc')
            ->orderBy('winner.name')
            ->groupBy('winner.division_id', 'winner.team_id', 'winner.name', 'winner.points')
            ->havingRaw('COUNT(winner.points) < ?', [3])
            ->get();
    }

    public function updateDivisionChampionEuropaTeam($division, $divisionColumn, $divisionTeam)
    {
        return Division::where('id', $division)
          ->update([$divisionColumn => $divisionTeam]);
    }

    public function getDivisionReportData($division)
    {
        $budget = $division->getOptionValue('seal_bids_budget');
        $quota = $division->getOptionValue('default_max_player_each_club');
        $squad = $division->getOptionValue('default_squad_size');
        $availableFormations = $division->getOptionValue('available_formations');
        $formations = format_formations($availableFormations);

        return compact('budget', 'quota', 'squad', 'formations');
    }

    public function getUserPackage($user)
    {
        return ($user->getPackage()) ? $user->getPackage() : Package::getFree();
    }

    public function getSocialLeagues()
    {
        return Division::select(['divisions.*', 'packages.minimum_teams', 'packages.maximum_teams'])->join('packages', 'packages.id', '=', 'divisions.package_id')->withCount('divisionTeams as team_count')
                ->where('packages.private_league', 'No')
                ->havingRaw('`team_count` < `packages`.`maximum_teams`')
                ->get();
    }

    public function getRulesData($division)
    {
        $budget = $division->getOptionValue('seal_bids_budget');
        $seasonBudget = $division->getOptionValue('pre_season_auction_budget');
        $isBudgetRollover = $division->getOptionValue('budget_rollover');
        $quota = $division->getOptionValue('default_max_player_each_club');
        $squad = $division->getOptionValue('default_squad_size');
        $availableFormations = $division->getOptionValue('available_formations');
        $formations = format_formations($availableFormations);
        $hasWeekendChanges = $division->getOptionValue('allow_weekend_changes');
        $seasonTransfer = $division->getOptionValue('season_free_agent_transfer_limit');
        $monthlyTransfer = $division->getOptionValue('monthly_free_agent_transfer_limit');
        $isAllowedTransfer = $division->getOptionValue('enable_free_agent_transfer');

        return compact('budget', 'seasonBudget', 'isBudgetRollover', 'quota', 'squad', 'formations', 'hasWeekendChanges', 'seasonTransfer', 'monthlyTransfer', 'isAllowedTransfer', 'division');
    }

    public function getPointsData($division)
    {
        $divisionPoints = $this->getCustomDivisionPoints($division);

        $pointsData = [];
        foreach ($divisionPoints as $event => $points) {
            if (count(array_unique($points)) === self::UNIQUE_VALUE) {
                $pointsData[$event] = end($points);
            }
        }
        unset($divisionPoints);

        return $pointsData;
    }

    public function getCustomDivisionPoints($division, $event = null)
    {
        $points = [];
        $positions = array_map('strtolower', TeamPointsPositionEnum::getKeys());

        //If Event is Specified
        if ($event) {
            foreach ($positions as $position) {
                $points[$event][$position] = ($division->getOptionValue($position, $event)) ? $division->getOptionValue($position, $event) : self::NULL_POINT;
            }

            return $points;
        }

        $events = array_map('strtolower', EventsEnum::getKeys());

        foreach ($events as $event) {
            foreach ($positions as $position) {
                $points[$event][$position] = ($division->getOptionValue($position, $event)) ? $division->getOptionValue($position, $event) : self::NULL_POINT;
            }
        }

        return $points;
    }

    public function updateIsViewedPackageSelection($division)
    {
        $division->fill([
            'is_viewed_package_selection' => true,
        ]);
        $division->save();

        return $division;
    }

    public function updatePackage($division, $data, $dbPackageId)
    {
        $package = Package::find($data['package_id']);
        $prize_pack_id = $division->prize_pack;
        if ($data['package_id'] != $dbPackageId) {
            $prize_pack_id = $package->default_prize_pack;
        }
        $division->fill([
            'package_id' => $data['package_id'],
            'pre_season_auction_budget' => $package->pre_season_auction_budget,
            'prize_pack'=>$prize_pack_id,
        ]);
        $division->save();

        return $division;
    }

    public function updatePrizePack($division, $data)
    {
        if (isset($data['prize_pack_id'])) {
            $division->fill([
                'prize_pack' => $data['prize_pack_id'],
            ]);
            $division->save();
        }

        return $division;
    }

    public function updateFreePlaceTeam($division)
    {
        $flag = false;
        if($division->package->free_placce_for_new_user == 'Yes') {
            $checkNewUserteam = $this->checkNewUserteam($division->chairman_id) && $this->checkNewUserteamPrevious($division->chairman_id);
            if($checkNewUserteam) {
                $divisionUid = Division::where('uuid', $division->uuid)->count();
                if($division->package->free_placce_for_new_user == 'Yes') {
                    if($divisionUid == 1 && $division->is_legacy == 0) {
                        $flag = true;
                    }
                }
            }

            $maxFreePlaces = intval($division->package->max_free_places);
            if ($maxFreePlaces > 0 && $division->package->free_placce_for_new_user == 'Yes') {
                foreach ($division->divisionTeams()->where('teams.is_ignored', 0)->get()->sortBy('created_at') as $key => $teamVal) {
                    $freePlace = $division->divisionTeams()->where('is_free', 1);
                    $team = Team::find($teamVal->id);
                    $checkNewUserteam = $this->checkNewUserteam($team->manager_id) && $this->checkNewUserteamPrevious($team->manager_id);
                    if ($checkNewUserteam) {
                        $divisionUid = Division::where('uuid', $division->uuid)->count();
                        if ($divisionUid > 1 || $division->is_legacy == 1) {
                            if ($division->package->free_placce_for_new_user == YesNoEnum::NO) {
                                if ($freePlace->count() >= $maxFreePlaces) {
                                    $checkNewUserteam = false;
                                }
                            } else {
                                $checkNewUserteam = false;
                            }
                        } else {
                            if ($division->package->free_placce_for_new_user == YesNoEnum::YES) {
                                if ($freePlace->count() >= $maxFreePlaces) {
                                    $checkNewUserteam = false;
                                }
                            } else {
                                $checkNewUserteam = false;
                            }
                        }
                    }
                    $team->teamDivision()->updateExistingPivot($division->id, ['season_id'=> Season::getLatestSeason(), 'is_free'=> $checkNewUserteam]);
                }
            }
        } else {
            DivisionTeam::where('division_id', $division->id)->update(['is_free' => $flag]);
        }

        return true;
    }

    public function checkNewUserteam($managerId)
    {
        $teams = Team::JOIN('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->where('division_teams.season_id', Season::getPreviousSeason())
            ->where('teams.manager_id', $managerId)
            ->count('division_teams.id');
        if ($teams > 0) {
            return false;
        }

        return true;
    }

    public function checkNewUserteamPrevious($managerId)
    {
        $teams = Team::JOIN('division_teams', 'division_teams.team_id', '=', 'teams.id')
        ->where('division_teams.season_id', Season::getLatestSeason())
        ->where('teams.manager_id', $managerId)
        ->where('teams.is_legacy', 1)
        ->count('teams.id');
        if ($teams > 0) {
            return false;
        }

        return true;
    }

    public function getTeamsById($teams)
    {
        return Team::whereIn('id', $teams)->get();
    }

    public function getCurrentSeasonPackages()
    {
        $seasonAvailablePackages = Season::find(Season::getLatestSeason())->available_packages;
        $packages = Package::where('private_league', YesNoEnum::YES)
                    ->whereIn('id',$seasonAvailablePackages)
                    ->get();

        return $packages;
    }
}
