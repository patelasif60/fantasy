# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

- [Season](/docs/{{version}}/api/division/league_standings/season)
- [Monthly](/docs/{{version}}/api/division/league_standings/month)
- [Weekly](/docs/{{version}}/api/division/league_standings/week)

---
<a name="division_edit"></a>
## League standings season

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`api/leagues/{league}/info/league_standings`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`filter`|String|`required`|`season`|

> {success} Success Response

Code `200`

Content

```json
{
    "division": {
        "id": 31,
        "name": "Matt Test QA League 2",
        "ownLeague": true,
        "package_id": 8,
        "introduction": null,
        "parent_division_id": null,
        "auction_types": "Online sealed bids",
        "auction_date": "2019-05-03 09:01:42",
        "pre_season_auction_budget": 200,
        "pre_season_auction_bid_increment": 1,
        "budget_rollover": "No",
        "seal_bids_budget": 50,
        "seal_bid_increment": "0.50",
        "seal_bid_minimum": 0,
        "manual_bid": "No",
        "first_seal_bid_deadline": "2019-05-03 09:01:42",
        "seal_bid_deadline_repeat": "everyMonth",
        "max_seal_bids_per_team_per_round": 5,
        "money_back": "none",
        "tie_preference": "lowerLeaguePositionWins",
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
        "merge_defenders": "Yes",
        "allow_weekend_changes": "Yes",
        "enable_free_agent_transfer": "Yes",
        "free_agent_transfer_authority": "chairman",
        "free_agent_transfer_after": "seasonStart",
        "season_free_agent_transfer_limit": 20,
        "monthly_free_agent_transfer_limit": 5,
        "co_chairman_id": [],
        "co_chairman": [],
        "season_start": true,
        "package": {
            "id": 8,
            "name": "Legend 18/19",
            "display_name": "Legend",
            "short_description": "Lorem ipsum dolor sit amet",
            "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
            "custom_squad_size": "Yes",
            "custom_club_quota": "Yes",
            "allow_custom_cup": "Yes",
            "allow_fa_cup": "Yes",
            "allow_champion_league": "Yes",
            "allow_europa_league": "Yes",
            "allow_head_to_head": "Yes",
            "allow_linked_league": "Yes",
            "allow_custom_scoring": "Yes"
        },
        "divisionPoints": [
            {
                "id": 337,
                "division_id": 31,
                "events": "goal",
                "goal_keeper": 8,
                "centre_back": 6,
                "full_back": 6,
                "defensive_mid_fielder": 5,
                "mid_fielder": 4,
                "striker": 3
            },
            {
                "id": 338,
                "division_id": 31,
                "events": "assist",
                "goal_keeper": 6,
                "centre_back": 5,
                "full_back": 5,
                "defensive_mid_fielder": 4,
                "mid_fielder": 3,
                "striker": 2
            },
            {
                "id": 339,
                "division_id": 31,
                "events": "goal_conceded",
                "goal_keeper": -1,
                "centre_back": -1,
                "full_back": -1,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 340,
                "division_id": 31,
                "events": "clean_sheet",
                "goal_keeper": 2,
                "centre_back": 2,
                "full_back": 2,
                "defensive_mid_fielder": 1,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 341,
                "division_id": 31,
                "events": "appearance",
                "goal_keeper": 1,
                "centre_back": 1,
                "full_back": 1,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 342,
                "division_id": 31,
                "events": "club_win",
                "goal_keeper": null,
                "centre_back": null,
                "full_back": null,
                "defensive_mid_fielder": 1,
                "mid_fielder": null,
                "striker": null
            },
            {
                "id": 343,
                "division_id": 31,
                "events": "red_card",
                "goal_keeper": -2,
                "centre_back": -2,
                "full_back": -2,
                "defensive_mid_fielder": -2,
                "mid_fielder": -2,
                "striker": -2
            },
            {
                "id": 344,
                "division_id": 31,
                "events": "yellow_card",
                "goal_keeper": -1,
                "centre_back": -1,
                "full_back": -1,
                "defensive_mid_fielder": -1,
                "mid_fielder": -1,
                "striker": -1
            },
            {
                "id": 345,
                "division_id": 31,
                "events": "own_goal",
                "goal_keeper": -3,
                "centre_back": -3,
                "full_back": -3,
                "defensive_mid_fielder": -3,
                "mid_fielder": -3,
                "striker": -3
            },
            {
                "id": 346,
                "division_id": 31,
                "events": "penalty_missed",
                "goal_keeper": -3,
                "centre_back": -3,
                "full_back": -3,
                "defensive_mid_fielder": -3,
                "mid_fielder": -3,
                "striker": -3
            },
            {
                "id": 347,
                "division_id": 31,
                "events": "penalty_save",
                "goal_keeper": 3,
                "centre_back": 3,
                "full_back": 3,
                "defensive_mid_fielder": 3,
                "mid_fielder": 3,
                "striker": 3
            },
            {
                "id": 348,
                "division_id": 31,
                "events": "goalkeeper_save_x5",
                "goal_keeper": 1,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            }
        ],
        "championLeague": 0,
        "europaLeague": 0,
        "europeanCups": true,
        "teams": [
            {
                "id": 155,
                "name": "Another Test Team 1"
            },
            {
                "id": 161,
                "name": "Another Test Team 2"
            },
            {
                "id": 162,
                "name": "Another Test Team 3"
            },
            {
                "id": 163,
                "name": "Another Test Team 4"
            },
            {
                "id": 164,
                "name": "Another Test Team 5"
            },
            {
                "id": 165,
                "name": "Ben's Team"
            }
        ],
        "champions_league_team": null,
        "europa_league_team_1": null,
        "europa_league_team_2": null,
        "changeNotAllowed": true,
        "customCups": [],
        "auction_message": false,
        "auction_closed": false
    },
    "teams": [
        {
            "total_goal": 6,
            "total_assist": 1,
            "total_clean_sheet": 1,
            "total_conceded": 7,
            "total_appearance": 6,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 1,
            "total_club_win": 6,
            "total_point": 31,
            "teamName": "Another Test Team 2",
            "teamId": 161,
            "first_name": "Matt",
            "last_name": "Sims",
            "total_point_week": null,
            "total_point_month": "31"
        },
        {
            "total_goal": 2,
            "total_assist": 3,
            "total_clean_sheet": 3,
            "total_conceded": 7,
            "total_appearance": 7,
            "total_own_goal": 0,
            "total_red_card": -1,
            "total_yellow_card": 2,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 6,
            "total_point": 26,
            "teamName": "Another Test Team 4",
            "teamId": 163,
            "first_name": "Matt",
            "last_name": "Sims",
            "total_point_week": null,
            "total_point_month": "26"
        },
        {
            "total_goal": 2,
            "total_assist": 2,
            "total_clean_sheet": 1,
            "total_conceded": 7,
            "total_appearance": 4,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 2,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 6,
            "total_point": 10,
            "teamName": "Another Test Team 5",
            "teamId": 164,
            "first_name": "Matt",
            "last_name": "Sims",
            "total_point_week": null,
            "total_point_month": "10"
        },
        {
            "total_goal": 1,
            "total_assist": 2,
            "total_clean_sheet": 2,
            "total_conceded": 9,
            "total_appearance": 7,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 2,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 8,
            "total_point": 14,
            "teamName": "Another Test Team 1",
            "teamId": 155,
            "first_name": "Matt",
            "last_name": "Sims",
            "total_point_week": null,
            "total_point_month": "14"
        },
        {
            "total_goal": 1,
            "total_assist": 0,
            "total_clean_sheet": 3,
            "total_conceded": 5,
            "total_appearance": 6,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 1,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 4,
            "total_point": 9,
            "teamName": "Another Test Team 3",
            "teamId": 162,
            "first_name": "Matt",
            "last_name": "Sims",
            "total_point_week": null,
            "total_point_month": "9"
        },
        {
            "total_goal": 0,
            "total_assist": 0,
            "total_clean_sheet": 0,
            "total_conceded": 0,
            "total_appearance": 0,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 0,
            "total_point": 0,
            "teamName": "Ben's Team",
            "teamId": 165,
            "first_name": "Ben",
            "last_name": "Grout",
            "total_point_week": null,
            "total_point_month": null
        }
    ],
    "season": {
        "id": 19,
        "name": "2018 - 2019",
        "start_at": "2018-08-09T00:00:00.000000Z",
        "end_at": "2019-05-13T00:00:00.000000Z"
    },
    "gameweeks": [
        {
            "id": 1,
            "number": "1",
            "is_valid_cup_round": true,
            "start": "2018-08-07T00:00:00.000000Z",
            "end": "2018-08-14T00:00:00.000000Z"
        },
        {
            "id": 2,
            "number": "2",
            "is_valid_cup_round": true,
            "start": "2018-08-14T00:00:00.000000Z",
            "end": "2018-08-21T00:00:00.000000Z"
        },
        {
            "id": 3,
            "number": "3",
            "is_valid_cup_round": true,
            "start": "2018-08-21T00:00:00.000000Z",
            "end": "2018-08-28T00:00:00.000000Z"
        },
        {
            "id": 4,
            "number": "4",
            "is_valid_cup_round": true,
            "start": "2018-08-28T00:00:00.000000Z",
            "end": "2018-09-04T00:00:00.000000Z"
        },
        {
            "id": 5,
            "number": "5",
            "is_valid_cup_round": false,
            "start": "2018-09-04T00:00:00.000000Z",
            "end": "2018-09-11T00:00:00.000000Z"
        },
        {
            "id": 6,
            "number": "6",
            "is_valid_cup_round": true,
            "start": "2018-09-11T00:00:00.000000Z",
            "end": "2018-09-18T00:00:00.000000Z"
        },
        {
            "id": 7,
            "number": "7",
            "is_valid_cup_round": true,
            "start": "2018-09-18T00:00:00.000000Z",
            "end": "2018-09-25T00:00:00.000000Z"
        },
        {
            "id": 8,
            "number": "8",
            "is_valid_cup_round": true,
            "start": "2018-09-25T00:00:00.000000Z",
            "end": "2018-10-02T00:00:00.000000Z"
        },
        {
            "id": 9,
            "number": "9",
            "is_valid_cup_round": true,
            "start": "2018-10-02T00:00:00.000000Z",
            "end": "2018-10-09T00:00:00.000000Z"
        },
        {
            "id": 10,
            "number": "10",
            "is_valid_cup_round": false,
            "start": "2018-10-09T00:00:00.000000Z",
            "end": "2018-10-16T00:00:00.000000Z"
        },
        {
            "id": 11,
            "number": "11",
            "is_valid_cup_round": true,
            "start": "2018-10-16T00:00:00.000000Z",
            "end": "2018-10-23T00:00:00.000000Z"
        },
        {
            "id": 12,
            "number": "12",
            "is_valid_cup_round": true,
            "start": "2018-10-23T00:00:00.000000Z",
            "end": "2018-10-30T00:00:00.000000Z"
        },
        {
            "id": 13,
            "number": "13",
            "is_valid_cup_round": true,
            "start": "2018-10-30T00:00:00.000000Z",
            "end": "2018-11-06T00:00:00.000000Z"
        },
        {
            "id": 14,
            "number": "14",
            "is_valid_cup_round": true,
            "start": "2018-11-06T00:00:00.000000Z",
            "end": "2018-11-13T00:00:00.000000Z"
        },
        {
            "id": 15,
            "number": "15",
            "is_valid_cup_round": false,
            "start": "2018-11-13T00:00:00.000000Z",
            "end": "2018-11-20T00:00:00.000000Z"
        },
        {
            "id": 16,
            "number": "16",
            "is_valid_cup_round": true,
            "start": "2018-11-20T00:00:00.000000Z",
            "end": "2018-11-27T00:00:00.000000Z"
        },
        {
            "id": 17,
            "number": "17",
            "is_valid_cup_round": true,
            "start": "2018-11-27T00:00:00.000000Z",
            "end": "2018-12-04T00:00:00.000000Z"
        },
        {
            "id": 18,
            "number": "18",
            "is_valid_cup_round": true,
            "start": "2018-12-04T00:00:00.000000Z",
            "end": "2018-12-11T00:00:00.000000Z"
        },
        {
            "id": 19,
            "number": "19",
            "is_valid_cup_round": true,
            "start": "2018-12-11T00:00:00.000000Z",
            "end": "2018-12-18T00:00:00.000000Z"
        },
        {
            "id": 20,
            "number": "20",
            "is_valid_cup_round": true,
            "start": "2018-12-18T00:00:00.000000Z",
            "end": "2018-12-25T00:00:00.000000Z"
        },
        {
            "id": 21,
            "number": "21",
            "is_valid_cup_round": true,
            "start": "2018-12-25T00:00:00.000000Z",
            "end": "2019-01-01T00:00:00.000000Z"
        },
        {
            "id": 22,
            "number": "22",
            "is_valid_cup_round": false,
            "start": "2019-01-01T00:00:00.000000Z",
            "end": "2019-01-08T00:00:00.000000Z"
        },
        {
            "id": 23,
            "number": "23",
            "is_valid_cup_round": true,
            "start": "2019-01-08T00:00:00.000000Z",
            "end": "2019-01-15T00:00:00.000000Z"
        },
        {
            "id": 24,
            "number": "24",
            "is_valid_cup_round": true,
            "start": "2019-01-15T00:00:00.000000Z",
            "end": "2019-01-22T00:00:00.000000Z"
        },
        {
            "id": 25,
            "number": "25",
            "is_valid_cup_round": false,
            "start": "2019-01-22T00:00:00.000000Z",
            "end": "2019-01-29T00:00:00.000000Z"
        },
        {
            "id": 26,
            "number": "26",
            "is_valid_cup_round": true,
            "start": "2019-01-29T00:00:00.000000Z",
            "end": "2019-02-05T00:00:00.000000Z"
        },
        {
            "id": 27,
            "number": "27",
            "is_valid_cup_round": true,
            "start": "2019-02-05T00:00:00.000000Z",
            "end": "2019-02-12T00:00:00.000000Z"
        },
        {
            "id": 28,
            "number": "28",
            "is_valid_cup_round": false,
            "start": "2019-02-12T00:00:00.000000Z",
            "end": "2019-02-19T00:00:00.000000Z"
        },
        {
            "id": 29,
            "number": "29",
            "is_valid_cup_round": false,
            "start": "2019-02-19T00:00:00.000000Z",
            "end": "2019-02-26T00:00:00.000000Z"
        },
        {
            "id": 30,
            "number": "30",
            "is_valid_cup_round": true,
            "start": "2019-02-26T00:00:00.000000Z",
            "end": "2019-03-05T00:00:00.000000Z"
        },
        {
            "id": 31,
            "number": "31",
            "is_valid_cup_round": true,
            "start": "2019-03-05T00:00:00.000000Z",
            "end": "2019-03-12T00:00:00.000000Z"
        },
        {
            "id": 32,
            "number": "32",
            "is_valid_cup_round": false,
            "start": "2019-03-12T00:00:00.000000Z",
            "end": "2019-03-19T00:00:00.000000Z"
        },
        {
            "id": 33,
            "number": "33",
            "is_valid_cup_round": false,
            "start": "2019-03-19T00:00:00.000000Z",
            "end": "2019-03-26T00:00:00.000000Z"
        },
        {
            "id": 34,
            "number": "34",
            "is_valid_cup_round": true,
            "start": "2019-03-26T00:00:00.000000Z",
            "end": "2019-04-02T00:00:00.000000Z"
        },
        {
            "id": 35,
            "number": "35",
            "is_valid_cup_round": true,
            "start": "2019-04-02T00:00:00.000000Z",
            "end": "2019-04-09T00:00:00.000000Z"
        },
        {
            "id": 36,
            "number": "36",
            "is_valid_cup_round": true,
            "start": "2019-04-09T00:00:00.000000Z",
            "end": "2019-04-16T00:00:00.000000Z"
        },
        {
            "id": 37,
            "number": "37",
            "is_valid_cup_round": false,
            "start": "2019-04-16T00:00:00.000000Z",
            "end": "2019-04-23T00:00:00.000000Z"
        },
        {
            "id": 38,
            "number": "38",
            "is_valid_cup_round": true,
            "start": "2019-04-23T00:00:00.000000Z",
            "end": "2019-04-30T00:00:00.000000Z"
        },
        {
            "id": 39,
            "number": "39",
            "is_valid_cup_round": true,
            "start": "2019-05-01T00:00:00.000000Z",
            "end": "2019-05-03T00:00:00.000000Z"
        },
        {
            "id": 40,
            "number": "40",
            "is_valid_cup_round": true,
            "start": "2019-05-07T00:00:00.000000Z",
            "end": "2019-05-14T00:00:00.000000Z"
        },
        {
            "id": 41,
            "number": "41",
            "is_valid_cup_round": false,
            "start": "2019-05-14T00:00:00.000000Z",
            "end": "2019-09-01T00:00:00.000000Z"
        }
    ],
    "columns": {
        "goal": 6,
        "assist": 6,
        "goal_conceded": 3,
        "clean_sheet": 4,
        "appearance": 3,
        "club_win": 1,
        "red_card": 6,
        "yellow_card": 6,
        "own_goal": 6,
        "penalty_missed": 6,
        "penalty_save": 6,
        "goalkeeper_save_x5": 1
    }
}
```
