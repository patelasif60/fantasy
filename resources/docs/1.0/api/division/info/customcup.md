# Custom Cup Fixtures API 

---

- [Custom Cup Rounds](#round_list)
- [Round Fixture](#round_fixtures)

<a name="round_list"></a>
## Custom cup rounds

This will return list of rounds for current selected league and custom cup. Also return running round fixtures.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/custom_cup/{customcup}`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/custom_cup/1`
|`customcup`|`integer`|`required`|Ex: `/api/leagues/1/info/custom_cup/1`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "activeRound": "3",
    "customCup": {
        "id": 1,
        "name": "Affan Cup",
        "division_id": 2,
        "is_bye_random": false,
        "status": "Active",
        "created_at": "2019-03-27 03:39:20",
        "updated_at": "2019-04-01 10:50:27",
        "rounds": [
            {
                "id": 1,
                "round": "1",
                "custom_cup_id": 1,
                "created_at": "2019-03-27 03:39:22",
                "updated_at": "2019-03-27 03:39:22",
                "gameweeks": [
                    {
                        "id": 1,
                        "custom_cup_round_id": 1,
                        "gameweek_id": 1,
                        "created_at": "2019-03-27 03:39:22",
                        "updated_at": "2019-03-27 03:39:22",
                        "gameweek": {
                            "id": 1,
                            "season_id": 19,
                            "number": "1",
                            "is_valid_cup_round": true,
                            "start": "2018-08-07 00:00:00",
                            "end": "2018-08-14 00:00:00",
                            "notes": "",
                            "created_at": "2019-03-12 05:34:43",
                            "updated_at": "2019-03-12 05:34:43"
                        }
                    },
                    {
                        "id": 2,
                        "custom_cup_round_id": 1,
                        "gameweek_id": 3,
                        "created_at": "2019-03-27 03:39:22",
                        "updated_at": "2019-03-27 03:39:22"
                    }
                ]
            },
            {
                "id": 2,
                "round": "2",
                "custom_cup_id": 1,
                "created_at": "2019-03-27 03:39:23",
                "updated_at": "2019-03-27 03:39:23"
            },
            {
                "id": 3,
                "round": "3",
                "custom_cup_id": 1,
                "created_at": "2019-03-27 03:39:24",
                "updated_at": "2019-03-27 03:39:24",
                "fixtures": [
                    {
                        "id": 19,
                        "season_id": 19,
                        "custom_cup_round_id": 3,
                        "gameweek_id": 8,
                        "home": 72,
                        "away": 23,
                        "home_points": 238,
                        "away_points": 17,
                        "winner": 72,
                        "created_at": "2019-04-01 10:50:27",
                        "updated_at": "2019-04-01 10:50:27",
                        "gameweek": {
                            "id": 8,
                            "season_id": 19,
                            "number": "8",
                            "is_valid_cup_round": true,
                            "start": "2018-09-25 00:00:00",
                            "end": "2018-10-02 00:00:00",
                            "notes": "",
                            "created_at": "2019-03-12 05:34:44",
                            "updated_at": "2019-03-12 05:34:44"
                        }
                    }
                ]
            }
        ]
    },
    "fixtures": [
        {
            "gameweek": "25th September - 2nd October 2018",
            "home_team_id": 72,
            "home_team_name": "Tony Rag Gentlemen",
            "home_manager": "Cortez Funk",
            "home_points": 238,
            "away_team_id": 23,
            "away_team_name": "Sonny Enchanting Gang",
            "away_points": 17,
            "away_manager": "Nakia Kozey"
        }
    ],
    "message": "Custom cup fixtures"
}
```
----
<a name="round_fixtures"></a>
## Round fixtures

This will return fixtures for pass custom cup round.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/custom_cup/{customcup}/round/filter?round={round}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/custom_cup/1/round/filter?round=1`
|`customcup`|`integer`|`required`|Ex: `/api/leagues/1/info/custom_cup/1/round/filter?round=1`
|`round`|`integer`|`required`|Ex: `/api/leagues/1/info/custom_cup/1/round/filter?round=1`

> {success} Success Response
round fixtures
Code `200`

Content

```json
{
    "status": "success",
    "data": [
        {
            "gameweek": "21st August - 28th August 2018",
            "home_team_id": 26,
            "home_team_name": "Itzel Rag Gentlemen",
            "home_manager": "Calista Monahan",
            "home_points": 11,
            "away_team_id": 7,
            "away_team_name": "Richard's Novice Team",
            "away_points": 1,
            "away_manager": "Richard Stenson"
        },
        {
            "gameweek": "21st August - 28th August 2018",
            "home_team_id": 72,
            "home_team_name": "Tony Rag Gentlemen",
            "home_manager": "Cortez Funk",
            "home_points": 36,
            "away_team_id": 21,
            "away_team_name": "Laurie Bizarre Butchers",
            "away_points": 7,
            "away_manager": "Gladyce Miller"
        },
        {
            "gameweek": "21st August - 28th August 2018",
            "home_team_id": 22,
            "home_team_name": "Kallie Bizarre Butchers",
            "home_manager": "Corrine Skiles",
            "home_points": 2,
            "away_team_id": 23,
            "away_team_name": "Sonny Enchanting Gang",
            "away_points": 5,
            "away_manager": "Nakia Kozey"
        },
        {
            "gameweek": "21st August - 28th August 2018",
            "home_team_id": 9,
            "home_team_name": "Stuart's Novice Team",
            "home_manager": "Stuart Walsh",
            "home_points": 15,
            "away_team_id": 6,
            "away_team_name": "Ben's Novice Team",
            "away_points": 4,
            "away_manager": "Ben Grout"
        }
    ]
}
```