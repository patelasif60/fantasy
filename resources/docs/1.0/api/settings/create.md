# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## Transfers and Sealed bids settings

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`leagues/{division}/transfer/settings`|`Bearer Token`|


### Response

> {success} Success Response

Code `200`

Content

```json
{
    "division": {
        "id": 930,
        "name": "Aecor R1",
        "uuid": "dcf5ce72-c1e8-4492-b981-6a47869c0b38",
        "chairman_id": 6,
        "package_id": 8,
        "prize_pack": 5,
        "introduction": null,
        "parent_division_id": null,
        "auction_types": "Live offline",
        "allow_passing_on_nominations": null,
        "remote_nomination_time_limit": null,
        "remote_bidding_time_limit": null,
        "allow_managers_to_enter_own_bids": "Yes",
        "auction_date": "2019-07-25 11:00:00",
        "pre_season_auction_budget": 50,
        "pre_season_auction_bid_increment": "0.25",
        "budget_rollover": "Yes",
        "seal_bids_budget": 0,
        "seal_bid_increment": "0.50",
        "seal_bid_minimum": "0.00",
        "manual_bid": null,
        "first_seal_bid_deadline": "2019-08-21 12:45:19",
        "seal_bid_deadline_repeat": "dontRepeat",
        "max_seal_bids_per_team_per_round": 5,
        "money_back": "hunderedPercent",
        "tie_preference": "lowerLeaguePositionWins",
        "rules": null,
        "default_squad_size": 13,
        "default_max_player_each_club": 2,
        "available_formations": [
            "442",
            "451",
            "433",
            "532",
            "541"
        ],
        "defensive_midfields": "No",
        "merge_defenders": "No",
        "allow_weekend_changes": "Yes",
        "enable_free_agent_transfer": "Yes",
        "free_agent_transfer_authority": "all",
        "free_agent_transfer_after": "seasonStart",
        "season_free_agent_transfer_limit": 1000,
        "monthly_free_agent_transfer_limit": 100,
        "champions_league_team": null,
        "europa_league_team_1": null,
        "europa_league_team_2": null,
        "created_at": "2019-07-18 18:11:27",
        "updated_at": "2020-01-22 14:52:38",
        "auction_venue": null,
        "auctioneer_id": 6,
        "auction_closing_date": "2019-08-09 17:36:59",
        "is_round_process": false,
        "is_viewed_package_selection": 1,
        "is_legacy": 0,
        "package": {
            "id": 8,
            "is_enabled": "Yes",
            "name": "Legend 19/20",
            "display_name": "Legend",
            "short_description": "Fully customisable, all you can eat",
            "long_description": "Fully customisable, all you can eat",
            "prize_packs": [
                "5",
                "1",
                "4"
            ],
            "default_prize_pack": 5,
            "available_new_user": "No",
            "price": "30.00",
            "private_league": "Yes",
            "minimum_teams": 5,
            "maximum_teams": 16,
            "auction_types": [
                "Live offline",
                "Online sealed bids"
            ],
            "pre_season_auction_budget": 200,
            "pre_season_auction_bid_increment": "1.00",
            "budget_rollover": "No",
            "seal_bids_budget": 0,
            "seal_bid_increment": "0.50",
            "seal_bid_minimum": "0.00",
            "manual_bid": "No",
            "first_seal_bid_deadline": "2018-08-03 12:00:00",
            "seal_bid_deadline_repeat": "everyMonth",
            "max_seal_bids_per_team_per_round": 5,
            "money_back": "none",
            "tie_preference": "lowerLeaguePositionWins",
            "custom_squad_size": "Yes",
            "default_squad_size": 15,
            "custom_club_quota": "Yes",
            "default_max_player_each_club": 2,
            "available_formations": [
                "442",
                "451",
                "433",
                "532",
                "541"
            ],
            "defensive_midfields": "No",
            "merge_defenders": "No",
            "enable_free_agent_transfer": "Yes",
            "free_agent_transfer_authority": "all",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "allow_weekend_changes": "Yes",
            "allow_custom_cup": "Yes",
            "allow_fa_cup": "Yes",
            "allow_champion_league": "Yes",
            "allow_europa_league": "Yes",
            "allow_pro_cup": "Yes",
            "allow_head_to_head": "Yes",
            "allow_linked_league": "Yes",
            "digital_prize_type": "Basic",
            "allow_custom_scoring": "Yes",
            "max_free_places": 2,
            "enable_supersubs": "Yes",
            "badge_color": "gold",
            "allow_auction_budget": "Yes",
            "allow_bid_increment": "Yes",
            "allow_process_bids": "Yes",
            "allow_defensive_midfielders": "Yes",
            "allow_merge_defenders": "Yes",
            "allow_weekend_changes_editable": "Yes",
            "allow_rollover_budget": "Yes",
            "allow_available_formations": "Yes",
            "allow_supersubs": "Yes",
            "allow_seal_bid_deadline_repeat": "Yes",
            "allow_season_free_agent_transfer_limit": "Yes",
            "allow_monthly_free_agent_transfer_limit": "Yes",
            "allow_free_agent_transfer_authority": "Yes",
            "allow_enable_free_agent_transfer": "Yes",
            "allow_free_agent_transfer_after": "Yes",
            "allow_seal_bid_minimum": "Yes",
            "allow_money_back": "Yes",
            "allow_tie_preference": "Yes",
            "money_back_types": [
                "none",
                "hunderedPercent",
                "fiftyPercent"
            ],
            "free_placce_for_new_user": "No",
            "allow_season_budget": "Yes",
            "allow_max_bids_per_round": "Yes",
            "created_at": "2019-07-09 12:12:24",
            "updated_at": "2019-11-15 07:45:51"
        },
        "transfer_rounds": [
            {
                "id": 579,
                "division_id": 930,
                "start": "2019-08-09 17:36:59",
                "end": "2019-08-31 11:00:00",
                "is_process": "P",
                "number": 1,
                "created_at": "2019-08-29 15:32:47",
                "updated_at": "2019-09-06 17:09:49"
            },
            {
                "id": 914,
                "division_id": 930,
                "start": "2019-08-31 11:00:00",
                "end": "2019-09-11 11:00:00",
                "is_process": "P",
                "number": 2,
                "created_at": "2019-09-11 08:35:47",
                "updated_at": "2019-09-11 12:48:48"
            },
            {
                "id": 919,
                "division_id": 930,
                "start": "2019-09-11 11:00:00",
                "end": "2019-09-11 14:00:00",
                "is_process": "P",
                "number": 3,
                "created_at": "2019-09-11 13:54:45",
                "updated_at": "2019-09-18 09:19:53"
            },
            {
                "id": 1088,
                "division_id": 930,
                "start": "2019-09-11 14:00:00",
                "end": "2019-09-18 11:00:00",
                "is_process": "P",
                "number": 4,
                "created_at": "2019-09-18 09:23:55",
                "updated_at": "2019-10-17 12:43:48"
            },
            {
                "id": 1842,
                "division_id": 930,
                "start": "2019-09-18 11:00:00",
                "end": "2019-09-19 13:00:00",
                "is_process": "P",
                "number": 5,
                "created_at": "2019-10-17 12:45:08",
                "updated_at": "2019-10-17 12:49:57"
            },
            {
                "id": 1845,
                "division_id": 930,
                "start": "2019-09-19 13:00:00",
                "end": "2019-10-17 13:05:00",
                "is_process": "P",
                "number": 6,
                "created_at": "2019-10-17 13:02:26",
                "updated_at": "2019-10-17 13:08:16"
            },
            {
                "id": 1919,
                "division_id": 930,
                "start": "2019-10-17 13:05:00",
                "end": "2019-10-18 09:00:00",
                "is_process": "P",
                "number": 7,
                "created_at": "2019-10-18 08:54:10",
                "updated_at": "2019-10-18 09:01:45"
            },
            {
                "id": 2211,
                "division_id": 930,
                "start": "2019-10-18 09:00:00",
                "end": "2020-01-21 11:45:00",
                "is_process": "P",
                "number": 8,
                "created_at": "2019-10-29 16:52:35",
                "updated_at": "2020-01-21 12:15:09"
            },
            {
                "id": 4485,
                "division_id": 930,
                "start": "2020-01-21 11:45:00",
                "end": "2020-01-22 14:50:00",
                "is_process": "P",
                "number": 9,
                "created_at": "2020-01-22 14:50:00",
                "updated_at": "2020-01-22 14:52:28"
            }
        ]
    },
    "package": {
        "id": 8,
        "is_enabled": "Yes",
        "name": "Legend 19/20",
        "display_name": "Legend",
        "short_description": "Fully customisable, all you can eat",
        "long_description": "Fully customisable, all you can eat",
        "prize_packs": [
            "5",
            "1",
            "4"
        ],
        "default_prize_pack": 5,
        "available_new_user": "No",
        "price": "30.00",
        "private_league": "Yes",
        "minimum_teams": 5,
        "maximum_teams": 16,
        "auction_types": [
            "Live offline",
            "Online sealed bids"
        ],
        "pre_season_auction_budget": 200,
        "pre_season_auction_bid_increment": "1.00",
        "budget_rollover": "No",
        "seal_bids_budget": 0,
        "seal_bid_increment": "0.50",
        "seal_bid_minimum": "0.00",
        "manual_bid": "No",
        "first_seal_bid_deadline": "2018-08-03 12:00:00",
        "seal_bid_deadline_repeat": "everyMonth",
        "max_seal_bids_per_team_per_round": 5,
        "money_back": "none",
        "tie_preference": "lowerLeaguePositionWins",
        "custom_squad_size": "Yes",
        "default_squad_size": 15,
        "custom_club_quota": "Yes",
        "default_max_player_each_club": 2,
        "available_formations": [
            "442",
            "451",
            "433",
            "532",
            "541"
        ],
        "defensive_midfields": "No",
        "merge_defenders": "No",
        "enable_free_agent_transfer": "Yes",
        "free_agent_transfer_authority": "all",
        "free_agent_transfer_after": "seasonStart",
        "season_free_agent_transfer_limit": 20,
        "monthly_free_agent_transfer_limit": 5,
        "allow_weekend_changes": "Yes",
        "allow_custom_cup": "Yes",
        "allow_fa_cup": "Yes",
        "allow_champion_league": "Yes",
        "allow_europa_league": "Yes",
        "allow_pro_cup": "Yes",
        "allow_head_to_head": "Yes",
        "allow_linked_league": "Yes",
        "digital_prize_type": "Basic",
        "allow_custom_scoring": "Yes",
        "max_free_places": 2,
        "enable_supersubs": "Yes",
        "badge_color": "gold",
        "allow_auction_budget": "Yes",
        "allow_bid_increment": "Yes",
        "allow_process_bids": "Yes",
        "allow_defensive_midfielders": "Yes",
        "allow_merge_defenders": "Yes",
        "allow_weekend_changes_editable": "Yes",
        "allow_rollover_budget": "Yes",
        "allow_available_formations": "Yes",
        "allow_supersubs": "Yes",
        "allow_seal_bid_deadline_repeat": "Yes",
        "allow_season_free_agent_transfer_limit": "Yes",
        "allow_monthly_free_agent_transfer_limit": "Yes",
        "allow_free_agent_transfer_authority": "Yes",
        "allow_enable_free_agent_transfer": "Yes",
        "allow_free_agent_transfer_after": "Yes",
        "allow_seal_bid_minimum": "Yes",
        "allow_money_back": "Yes",
        "allow_tie_preference": "Yes",
        "money_back_types": [
            "none",
            "hunderedPercent",
            "fiftyPercent"
        ],
        "free_placce_for_new_user": "No",
        "allow_season_budget": "Yes",
        "allow_max_bids_per_round": "Yes",
        "created_at": "2019-07-09 12:12:24",
        "updated_at": "2019-11-15 07:45:51"
    },
    "transferRounds": [
        {
            "id": 579,
            "division_id": 930,
            "start": "2019-08-09 17:36:59",
            "end": "2019-08-31 11:00:00",
            "endDate": "31-08-2019",
            "endTime": "11:00:00",
            "is_end": true,
            "is_process": "P",
            "number": 1
        },
        {
            "id": 914,
            "division_id": 930,
            "start": "2019-08-31 11:00:00",
            "end": "2019-09-11 11:00:00",
            "endDate": "11-09-2019",
            "endTime": "11:00:00",
            "is_end": true,
            "is_process": "P",
            "number": 2
        },
        {
            "id": 919,
            "division_id": 930,
            "start": "2019-09-11 11:00:00",
            "end": "2019-09-11 14:00:00",
            "endDate": "11-09-2019",
            "endTime": "14:00:00",
            "is_end": true,
            "is_process": "P",
            "number": 3
        },
        {
            "id": 1088,
            "division_id": 930,
            "start": "2019-09-11 14:00:00",
            "end": "2019-09-18 11:00:00",
            "endDate": "18-09-2019",
            "endTime": "11:00:00",
            "is_end": true,
            "is_process": "P",
            "number": 4
        },
        {
            "id": 1842,
            "division_id": 930,
            "start": "2019-09-18 11:00:00",
            "end": "2019-09-19 13:00:00",
            "endDate": "19-09-2019",
            "endTime": "13:00:00",
            "is_end": true,
            "is_process": "P",
            "number": 5
        },
        {
            "id": 1845,
            "division_id": 930,
            "start": "2019-09-19 13:00:00",
            "end": "2019-10-17 13:05:00",
            "endDate": "17-10-2019",
            "endTime": "13:05:00",
            "is_end": true,
            "is_process": "P",
            "number": 6
        },
        {
            "id": 1919,
            "division_id": 930,
            "start": "2019-10-17 13:05:00",
            "end": "2019-10-18 09:00:00",
            "endDate": "18-10-2019",
            "endTime": "09:00:00",
            "is_end": true,
            "is_process": "P",
            "number": 7
        },
        {
            "id": 2211,
            "division_id": 930,
            "start": "2019-10-18 09:00:00",
            "end": "2020-01-21 11:45:00",
            "endDate": "21-01-2020",
            "endTime": "11:45:00",
            "is_end": true,
            "is_process": "P",
            "number": 8
        },
        {
            "id": 4485,
            "division_id": 930,
            "start": "2020-01-21 11:45:00",
            "end": "2020-01-22 14:50:00",
            "endDate": "22-01-2020",
            "endTime": "14:50:00",
            "is_end": true,
            "is_process": "P",
            "number": 9
        }
    ],
    "sealedBidDeadLinesEnum": {
        "dontRepeat": "Don’t repeat",
        "everyMonth": "Every month",
        "everyFortnight": "Every fortnight",
        "everyWeek": "Every week"
    },
    "tiePreferenceEnum": {
        "no": "No tie preference",
        "earliestBidWins": "Earliest bid wins",
        "lowerLeaguePositionWins": "Lower league position wins",
        "higherLeaguePositionWins": "Higher league position wins",
        "randomlyAllocated": "Randomly allocated",
        "randomlyAllocatedReverses": "Randomly allocated, then reverses each round"
    },
    "agentTransferAfterEnum": {
        "auctionEnd": "Auction end",
        "seasonStart": "Season start"
    },
    "moneyBackEnum": {
        "none": "None",
        "hunderedPercent": "Full bought price",
        "fiftyPercent": "Half of bought price",
        "chairmaneditboughtsoldprice": "Chairman can edit bought and sold price"
    },
    "isPostAuctionState": true,
    "dateFormat": "DD/MM/YYYY",
    "unprocessRoundCount": 0
}
```
