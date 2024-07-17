# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name="get_details"></a>
## Get details of Overall stadings

This API will fecth data like packages, month, week which will be usefull for other overall ranking APIs.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/standings`|`Bearer Token`|


### URL Params

|Params|Type|Values|Example|
|:-|:-|:-|
|`division`|Integer|`required`|Ex:`1`|

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "packages": {
            "5": "Novice 19/20",
            "7": "Pro 19/20",
            "8": "Legend 19/20"
        },
        "months": [
            {
                "startDate": "2019-08-01T00:00:00.000000Z",
                "endDate": "2019-08-31T23:59:59.999999Z"
            },
            {
                "startDate": "2019-09-01T00:00:00.000000Z",
                "endDate": "2019-09-30T23:59:59.999999Z"
            },
            {
                "startDate": "2019-10-01T00:00:00.000000Z",
                "endDate": "2019-10-31T23:59:59.999999Z"
            },
            {
                "startDate": "2019-11-01T00:00:00.000000Z",
                "endDate": "2019-11-30T23:59:59.999999Z"
            },
            {
                "startDate": "2019-12-01T00:00:00.000000Z",
                "endDate": "2019-12-31T23:59:59.999999Z"
            },
            {
                "startDate": "2020-01-01T00:00:00.000000Z",
                "endDate": "2020-01-31T23:59:59.999999Z"
            },
            {
                "startDate": "2020-02-01T00:00:00.000000Z",
                "endDate": "2020-02-29T23:59:59.999999Z"
            },
            {
                "startDate": "2020-03-01T00:00:00.000000Z",
                "endDate": "2020-03-31T23:59:59.999999Z"
            },
            {
                "startDate": "2020-04-01T00:00:00.000000Z",
                "endDate": "2020-04-30T23:59:59.999999Z"
            },
            {
                "startDate": "2020-05-01T00:00:00.000000Z",
                "endDate": "2020-05-31T23:59:59.999999Z"
            }
        ],
        "gameweeks": [
            {
                "id": 42,
                "season_id": 30,
                "number": "1",
                "is_valid_cup_round": true,
                "start": "2019-06-01 00:00:00",
                "end": "2019-08-13 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-10 11:52:15"
            },
            {
                "id": 43,
                "season_id": 30,
                "number": "2",
                "is_valid_cup_round": true,
                "start": "2019-08-13 00:00:00",
                "end": "2019-08-20 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-09 12:16:07"
            },
            {
                "id": 44,
                "season_id": 30,
                "number": "3",
                "is_valid_cup_round": true,
                "start": "2019-08-20 00:00:00",
                "end": "2019-08-27 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-09 12:16:07"
            },
            {
                "id": 45,
                "season_id": 30,
                "number": "4",
                "is_valid_cup_round": true,
                "start": "2019-08-27 00:00:00",
                "end": "2019-09-03 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-09 12:16:07"
            },
            {
                "id": 46,
                "season_id": 30,
                "number": "5",
                "is_valid_cup_round": false,
                "start": "2019-09-03 00:00:00",
                "end": "2019-09-10 00:00:00",
                "notes": "INTERNATIONAL",
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-09 12:16:07"
            },
            {
                "id": 47,
                "season_id": 30,
                "number": "6",
                "is_valid_cup_round": true,
                "start": "2019-09-10 00:00:00",
                "end": "2019-09-17 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-09 12:16:07"
            },
            {
                "id": 48,
                "season_id": 30,
                "number": "7",
                "is_valid_cup_round": true,
                "start": "2019-09-17 00:00:00",
                "end": "2019-09-24 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:07",
                "updated_at": "2019-07-09 12:16:07"
            },
            {
                "id": 49,
                "season_id": 30,
                "number": "8",
                "is_valid_cup_round": true,
                "start": "2019-09-24 00:00:00",
                "end": "2019-10-01 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 50,
                "season_id": 30,
                "number": "9",
                "is_valid_cup_round": true,
                "start": "2019-10-01 00:00:00",
                "end": "2019-10-08 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 51,
                "season_id": 30,
                "number": "10",
                "is_valid_cup_round": false,
                "start": "2019-10-08 00:00:00",
                "end": "2019-10-15 00:00:00",
                "notes": "INTERNATIONAL",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 52,
                "season_id": 30,
                "number": "11",
                "is_valid_cup_round": true,
                "start": "2019-10-15 00:00:00",
                "end": "2019-10-22 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 53,
                "season_id": 30,
                "number": "12",
                "is_valid_cup_round": true,
                "start": "2019-10-22 00:00:00",
                "end": "2019-10-29 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 54,
                "season_id": 30,
                "number": "13",
                "is_valid_cup_round": true,
                "start": "2019-10-29 00:00:00",
                "end": "2019-11-05 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:52:32"
            },
            {
                "id": 55,
                "season_id": 30,
                "number": "14",
                "is_valid_cup_round": true,
                "start": "2019-11-05 00:00:00",
                "end": "2019-11-12 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:52:05"
            },
            {
                "id": 56,
                "season_id": 30,
                "number": "15",
                "is_valid_cup_round": false,
                "start": "2019-11-12 00:00:00",
                "end": "2019-11-19 00:00:00",
                "notes": "INTERNATIONAL",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 57,
                "season_id": 30,
                "number": "16",
                "is_valid_cup_round": true,
                "start": "2019-11-19 00:00:00",
                "end": "2019-11-26 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-11-26 08:31:22"
            },
            {
                "id": 58,
                "season_id": 30,
                "number": "17",
                "is_valid_cup_round": true,
                "start": "2019-11-26 00:00:00",
                "end": "2019-12-03 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-11-26 08:31:05"
            },
            {
                "id": 59,
                "season_id": 30,
                "number": "18",
                "is_valid_cup_round": true,
                "start": "2019-12-03 00:00:00",
                "end": "2019-12-10 00:00:00",
                "notes": "MIDWEEK",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 60,
                "season_id": 30,
                "number": "19",
                "is_valid_cup_round": true,
                "start": "2019-12-10 00:00:00",
                "end": "2019-12-17 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:50:27"
            },
            {
                "id": 61,
                "season_id": 30,
                "number": "20",
                "is_valid_cup_round": true,
                "start": "2019-12-17 00:00:00",
                "end": "2019-12-24 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:49:44"
            },
            {
                "id": 62,
                "season_id": 30,
                "number": "21",
                "is_valid_cup_round": true,
                "start": "2019-12-24 00:00:00",
                "end": "2019-12-31 00:00:00",
                "notes": "MIDWEEK",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 63,
                "season_id": 30,
                "number": "22",
                "is_valid_cup_round": true,
                "start": "2019-12-31 00:00:00",
                "end": "2020-01-07 00:00:00",
                "notes": "MIDWEEK, FA CUP RND 3",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 64,
                "season_id": 30,
                "number": "23",
                "is_valid_cup_round": true,
                "start": "2020-01-07 00:00:00",
                "end": "2020-01-14 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:44:04"
            },
            {
                "id": 65,
                "season_id": 30,
                "number": "24",
                "is_valid_cup_round": true,
                "start": "2020-01-14 00:00:00",
                "end": "2020-01-21 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:43:41"
            },
            {
                "id": 66,
                "season_id": 30,
                "number": "25",
                "is_valid_cup_round": true,
                "start": "2020-01-21 00:00:00",
                "end": "2020-01-28 00:00:00",
                "notes": "MIDWEEK, FA CUP RND 4",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 67,
                "season_id": 30,
                "number": "26",
                "is_valid_cup_round": true,
                "start": "2020-01-28 00:00:00",
                "end": "2020-02-04 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:42:49"
            },
            {
                "id": 68,
                "season_id": 30,
                "number": "27",
                "is_valid_cup_round": true,
                "start": "2020-02-04 00:00:00",
                "end": "2020-02-11 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:42:30"
            },
            {
                "id": 69,
                "season_id": 30,
                "number": "28",
                "is_valid_cup_round": false,
                "start": "2020-02-11 00:00:00",
                "end": "2020-02-18 00:00:00",
                "notes": "INTERNATIONAL",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 70,
                "season_id": 30,
                "number": "29",
                "is_valid_cup_round": true,
                "start": "2020-02-18 00:00:00",
                "end": "2020-02-25 00:00:00",
                "notes": null,
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-09-26 06:42:02"
            },
            {
                "id": 71,
                "season_id": 30,
                "number": "30",
                "is_valid_cup_round": false,
                "start": "2020-02-25 00:00:00",
                "end": "2020-03-03 00:00:00",
                "notes": "LEAGUE CUP FINAL",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 72,
                "season_id": 30,
                "number": "31",
                "is_valid_cup_round": true,
                "start": "2020-03-03 00:00:00",
                "end": "2020-03-10 00:00:00",
                "notes": "FA CUP RND 5 (MIDWEEK)",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 73,
                "season_id": 30,
                "number": "32",
                "is_valid_cup_round": true,
                "start": "2020-03-10 00:00:00",
                "end": "2020-03-17 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 74,
                "season_id": 30,
                "number": "33",
                "is_valid_cup_round": false,
                "start": "2020-03-17 00:00:00",
                "end": "2020-03-24 00:00:00",
                "notes": "FA CUP QF",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 75,
                "season_id": 30,
                "number": "34",
                "is_valid_cup_round": true,
                "start": "2020-03-24 00:00:00",
                "end": "2020-03-31 00:00:00",
                "notes": "INTERNATIONAL",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 76,
                "season_id": 30,
                "number": "35",
                "is_valid_cup_round": true,
                "start": "2020-03-31 00:00:00",
                "end": "2020-04-07 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 77,
                "season_id": 30,
                "number": "36",
                "is_valid_cup_round": true,
                "start": "2020-04-07 00:00:00",
                "end": "2020-04-14 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 78,
                "season_id": 30,
                "number": "37",
                "is_valid_cup_round": false,
                "start": "2020-04-14 00:00:00",
                "end": "2020-04-21 00:00:00",
                "notes": "FA CUP SF",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 79,
                "season_id": 30,
                "number": "38",
                "is_valid_cup_round": true,
                "start": "2020-04-21 00:00:00",
                "end": "2020-04-28 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 80,
                "season_id": 30,
                "number": "39",
                "is_valid_cup_round": true,
                "start": "2020-04-28 00:00:00",
                "end": "2020-05-05 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 81,
                "season_id": 30,
                "number": "40",
                "is_valid_cup_round": true,
                "start": "2020-05-05 00:00:00",
                "end": "2020-05-12 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 82,
                "season_id": 30,
                "number": "41",
                "is_valid_cup_round": true,
                "start": "2020-05-12 00:00:00",
                "end": "2020-05-19 00:00:00",
                "notes": "",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            },
            {
                "id": 83,
                "season_id": 30,
                "number": "42",
                "is_valid_cup_round": false,
                "start": "2020-05-19 00:00:00",
                "end": "2020-05-26 00:00:00",
                "notes": "FA CUP FINAL",
                "created_at": "2019-07-09 12:16:08",
                "updated_at": "2019-07-09 12:16:08"
            }
        ],
        "activeWeekId": 60,
        "division": {
            "id": 223,
            "name": "Banbury Boys Get Up Hurley In The Morning",
            "uuid": "5c9ce3a7-d6c8-45f3-8c54-07546fece790",
            "chairman_id": 6,
            "package_id": 8,
            "prize_pack": 5,
            "introduction": null,
            "parent_division_id": null,
            "auction_types": "Live offline",
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_date": "2019-08-04 11:00:00",
            "pre_season_auction_budget": 40,
            "pre_season_auction_bid_increment": "0.10",
            "budget_rollover": "Yes",
            "seal_bids_budget": 0,
            "seal_bid_increment": "0.10",
            "seal_bid_minimum": "0.00",
            "manual_bid": null,
            "first_seal_bid_deadline": "2019-07-10 03:22:15",
            "seal_bid_deadline_repeat": "everyWeek",
            "max_seal_bids_per_team_per_round": 5,
            "money_back": "fiftyPercent",
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
            "defensive_midfields": "No",
            "merge_defenders": "No",
            "allow_weekend_changes": "No",
            "enable_free_agent_transfer": "Yes",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 15,
            "monthly_free_agent_transfer_limit": 5,
            "champions_league_team": 1614,
            "europa_league_team_1": 1615,
            "europa_league_team_2": 1617,
            "created_at": "2019-07-09 13:09:12",
            "updated_at": "2019-12-06 07:54:07",
            "auction_venue": "Elephant & Castle, Bloxham",
            "auctioneer_id": 6,
            "auction_closing_date": "2019-08-05 16:11:48",
            "is_round_process": false,
            "is_viewed_package_selection": 1,
            "is_legacy": 1
        }
    }
}
```
