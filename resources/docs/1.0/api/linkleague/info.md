# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Get Link League Info](#get_league_info)

<a name="get_league_info"></a>
## Link League Info

This api contains month & week data need to display for link league standings and other variable required 
for further apis of link league
### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/linkedLeagues/{parent_linked_league_id}/info`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`
|`parent_linked_league_id`|`integer`|`valid numeric parent linked league id id`|Ex: `1`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "months": [
            {
                "monthName": "June",
                "startDate": "2019-06-01T00:00:00.000000Z",
                "endDate": "2019-06-30T23:59:59.999999Z"
            },
            {
                "monthName": "July",
                "startDate": "2019-07-01T00:00:00.000000Z",
                "endDate": "2019-07-31T23:59:59.999999Z"
            },
            {
                "monthName": "August",
                "startDate": "2019-08-01T00:00:00.000000Z",
                "endDate": "2019-08-31T23:59:59.999999Z"
            },
            {
                "monthName": "September",
                "startDate": "2019-09-01T00:00:00.000000Z",
                "endDate": "2019-09-30T23:59:59.999999Z"
            },
            {
                "monthName": "October",
                "startDate": "2019-10-01T00:00:00.000000Z",
                "endDate": "2019-10-31T23:59:59.999999Z"
            },
            {
                "monthName": "November",
                "startDate": "2019-11-01T00:00:00.000000Z",
                "endDate": "2019-11-30T23:59:59.999999Z"
            },
            {
                "monthName": "December",
                "startDate": "2019-12-01T00:00:00.000000Z",
                "endDate": "2019-12-31T23:59:59.999999Z"
            },
            {
                "monthName": "January",
                "startDate": "2020-01-01T00:00:00.000000Z",
                "endDate": "2020-01-31T23:59:59.999999Z"
            },
            {
                "monthName": "February",
                "startDate": "2020-02-01T00:00:00.000000Z",
                "endDate": "2020-02-29T23:59:59.999999Z"
            },
            {
                "monthName": "March",
                "startDate": "2020-03-01T00:00:00.000000Z",
                "endDate": "2020-03-31T23:59:59.999999Z"
            },
            {
                "monthName": "April",
                "startDate": "2020-04-01T00:00:00.000000Z",
                "endDate": "2020-04-30T23:59:59.999999Z"
            },
            {
                "monthName": "May",
                "startDate": "2020-05-01T00:00:00.000000Z",
                "endDate": "2020-05-31T23:59:59.999999Z"
            },
            {
                "monthName": "June",
                "startDate": "2020-06-01T00:00:00.000000Z",
                "endDate": "2020-06-30T23:59:59.999999Z"
            },
            {
                "monthName": "July",
                "startDate": "2020-07-01T00:00:00.000000Z",
                "endDate": "2020-07-31T23:59:59.999999Z"
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
        "parentLinkedLeague": 12,
        "events": {
            "GOAL": "goal",
            "ASSIST": "assist",
            "GOAL_CONCEDED": "goal_conceded",
            "CLEAN_SHEET": "clean_sheet",
            "APPEARANCE": "appearance",
            "CLUB_WIN": "club_win",
            "RED_CARD": "red_card",
            "YELLOW_CARD": "yellow_card",
            "OWN_GOAL": "own_goal",
            "PENALTY_MISSED": "penalty_missed",
            "PENALTY_SAVE": "penalty_save",
            "GOALKEEPER_SAVE_X5": "goalkeeper_save_x5"
        },
        "columns": {
            "goal": 6,
            "assist": 6,
            "goal_conceded": 3,
            "clean_sheet": 3,
            "appearance": 3,
            "club_win": 0,
            "red_card": 0,
            "yellow_card": 0,
            "own_goal": 0,
            "penalty_missed": 0,
            "penalty_save": 0,
            "goalkeeper_save_x5": 0
        }
    }
}
```
