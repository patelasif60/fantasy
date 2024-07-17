# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Scoring System](#scoring_system)

<a name="scoring_system"></a>
## Scoring System

Scoring System to be shown to a team manager (not a chairman) when a league is in preauction state

### Endpoint

> {warning} Please note that this link will only be visible in Preauction state.

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/preauction/rules/scoring/data`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
    "data": {
        "events": {
            "goal": "Goal",
            "assist": "Assist",
            "goal_conceded": "Goal conceded",
            "clean_sheet": "Clean sheet",
            "appearance": "Appearance",
            "club_win": "Club win",
            "red_card": "Red card",
            "yellow_card": "Yellow card",
            "own_goal": "Own goal",
            "penalty_missed": "Penalty missed",
            "penalty_save": "Penalty save",
            "goalkeeper_save_x5": "Goalkeeper save x5"
        },
        "same_point_events": {
            "goal": 3,
            "assist": 2,
            "club_win": 0,
            "red_card": 0,
            "yellow_card": 0,
            "own_goal": 0,
            "penalty_missed": 0,
            "penalty_save": 0,
            "goalkeeper_save_x5": 0
        },
        "points_data": {
            "goal": {
                "goal_keeper": 3,
                "full_back": 3,
                "centre_back": 3,
                "defensive_mid_fielder": 3,
                "mid_fielder": 3,
                "striker": 3
            },
            "assist": {
                "goal_keeper": 2,
                "full_back": 2,
                "centre_back": 2,
                "defensive_mid_fielder": 2,
                "mid_fielder": 2,
                "striker": 2
            },
            "goal_conceded": {
                "goal_keeper": -1,
                "full_back": -1,
                "centre_back": -1,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "clean_sheet": {
                "goal_keeper": 2,
                "full_back": 2,
                "centre_back": 2,
                "defensive_mid_fielder": 2,
                "mid_fielder": 0,
                "striker": 0
            },
            "appearance": {
                "goal_keeper": 1,
                "full_back": 1,
                "centre_back": 1,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "club_win": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "red_card": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "yellow_card": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "own_goal": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "penalty_missed": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "penalty_save": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            "goalkeeper_save_x5": {
                "goal_keeper": 0,
                "full_back": 0,
                "centre_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            }
        },
        "division": {
            "id": 2,
            "name": "A Really Loooooooong name for a league",
            "uuid": "0650b39a-69a5-46f9-8b5a-7330e8d76018",
            "chairman_id": 35,
            "package_id": 5,
            "prize_pack": null,
            "introduction": null,
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null,
            "auction_date": "2019-05-17 09:00:38",
            "pre_season_auction_budget": 200,
            "pre_season_auction_bid_increment": 1,
            "budget_rollover": "Yes",
            "seal_bids_budget": 50,
            "seal_bid_increment": "0.50",
            "seal_bid_minimum": 0,
            "manual_bid": "Yes",
            "first_seal_bid_deadline": "2019-03-18 14:52:43",
            "seal_bid_deadline_repeat": "everyMonth",
            "max_seal_bids_per_team_per_round": 5,
            "money_back": "none",
            "tie_preference": "no",
            "rules": null,
            "default_squad_size": 15,
            "default_max_player_each_club": 2,
            "available_formations": [
                "442",
                "451",
                "433",
                "532",
                "541"
            ],
            "defensive_midfields": "Yes",
            "merge_defenders": "No",
            "allow_weekend_changes": "No",
            "enable_free_agent_transfer": "No",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "champions_league_team": 10,
            "europa_league_team_1": 6,
            "europa_league_team_2": 8,
            "created_at": "2019-03-13 13:17:28",
            "updated_at": "2019-05-03 13:35:06",
            "auction_venue": "uk",
            "auctioneer_id": 33,
            "auction_closing_date": "2019-06-07 15:29:32",
            "is_round_process": false,
            "division_points": [],
            "package": {
                "id": 5,
                "is_enabled": "Yes",
                "name": "Novice 18/19",
                "display_name": "Novice",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "prize_packs": null,
                "available_new_user": "Yes",
                "price": "0.00",
                "private_league": "Yes",
                "minimum_teams": 5,
                "maximum_teams": 10,
                "auction_types": [
                    "Online sealed bids",
                    "Live online",
                    "Live offline"
                ],
                "pre_season_auction_budget": 200,
                "pre_season_auction_bid_increment": 1,
                "budget_rollover": "No",
                "seal_bids_budget": 50,
                "seal_bid_increment": "0.50",
                "seal_bid_minimum": 0,
                "manual_bid": "No",
                "first_seal_bid_deadline": "2018-08-03 12:00:00",
                "seal_bid_deadline_repeat": "everyMonth",
                "max_seal_bids_per_team_per_round": 5,
                "money_back": "none",
                "tie_preference": "lowerLeaguePositionWins",
                "custom_squad_size": "No",
                "default_squad_size": 15,
                "custom_club_quota": "No",
                "default_max_player_each_club": 2,
                "available_formations": [
                    "442",
                    "451",
                    "433",
                    "532",
                    "541"
                ],
                "defensive_midfields": "No",
                "merge_defenders": "Yes",
                "enable_free_agent_transfer": "No",
                "free_agent_transfer_authority": "chairman",
                "free_agent_transfer_after": "seasonStart",
                "season_free_agent_transfer_limit": 20,
                "monthly_free_agent_transfer_limit": 5,
                "allow_weekend_changes": "No",
                "allow_custom_cup": "Yes",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "Yes",
                "allow_europa_league": "Yes",
                "allow_pro_cup": "Yes",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "digital_prize_type": "Basic",
                "allow_custom_scoring": "No",
                "max_free_places": 0,
                "created_at": "2019-03-13 13:17:26",
                "updated_at": "2019-05-20 16:13:13",
                "package_points": [
                    {
                        "id": 49,
                        "package_id": 5,
                        "events": "goal",
                        "goal_keeper": 3,
                        "centre_back": 3,
                        "full_back": 3,
                        "defensive_mid_fielder": 3,
                        "mid_fielder": 3,
                        "striker": 3,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-05-20 16:13:13"
                    },
                    {
                        "id": 50,
                        "package_id": 5,
                        "events": "assist",
                        "goal_keeper": 2,
                        "centre_back": 2,
                        "full_back": 2,
                        "defensive_mid_fielder": 2,
                        "mid_fielder": 2,
                        "striker": 2,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-05-20 16:13:13"
                    },
                    {
                        "id": 51,
                        "package_id": 5,
                        "events": "goal_conceded",
                        "goal_keeper": -1,
                        "centre_back": -1,
                        "full_back": -1,
                        "defensive_mid_fielder": 0,
                        "mid_fielder": 0,
                        "striker": 0,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-05-20 16:13:13"
                    },
                    {
                        "id": 52,
                        "package_id": 5,
                        "events": "clean_sheet",
                        "goal_keeper": 2,
                        "centre_back": 2,
                        "full_back": 2,
                        "defensive_mid_fielder": 2,
                        "mid_fielder": 0,
                        "striker": 0,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-05-20 16:13:13"
                    },
                    {
                        "id": 53,
                        "package_id": 5,
                        "events": "appearance",
                        "goal_keeper": 1,
                        "centre_back": 1,
                        "full_back": 1,
                        "defensive_mid_fielder": 0,
                        "mid_fielder": 0,
                        "striker": 0,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-05-20 16:13:13"
                    }
                ]
            }
        }
    }
}
```
> {info} The Scoring System is to be shown in the mentioned screens as per the PRE-3.2 Pre-auction state mock-up.

> {danger} Error Response

Code `422`

Reason `League/Team is in post auction state & user is a chairman of the league.`

Content

```json
{
    "status": "error",
    "message": "Not authorized."
}
```
