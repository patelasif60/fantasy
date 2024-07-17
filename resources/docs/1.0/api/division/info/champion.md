# Champion League

---

- [Champion League Phases](#champion_phases_list)
- [Champion League Fixture](#champion_fixtures)
- [Champion Group View](#champion_group_view)

<a name="champion_phases_list"></a>
## Champion league phases

This will return list of phases for current selected league. Also return latest phase fixture detail.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/competition?competition={competition_type}`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/competition?competition=champion`
|`competition`|`string`|`required`|Ex: `/api/leagues/1/info/competition?competition=champion`

> {success} Success Response

Code `200`

Content

```json
{
    "phases": [
        {
            "id": 1,
            "name": "Group stage - game 1",
            "group_no": 91,
            "start": "2019-11-19",
            "end": "2019-11-26"
        },
        {
            "id": 3,
            "name": "Group stage - game 2",
            "group_no": 91,
            "start": "2019-11-26",
            "end": "2019-12-03"
        },
        {
            "id": 5,
            "name": "Group stage - game 3",
            "group_no": 91,
            "start": "2019-12-10",
            "end": "2019-12-17"
        },
        {
            "id": 7,
            "name": "Group stage - game 4",
            "group_no": 91,
            "start": "2019-12-17",
            "end": "2019-12-24"
        },
        {
            "id": 9,
            "name": "Group stage - game 5",
            "group_no": 91,
            "start": "2020-01-07",
            "end": "2020-01-14"
        },
        {
            "id": 11,
            "name": "Group stage - game 6",
            "group_no": 91,
            "start": "2020-01-14",
            "end": "2020-01-21"
        }
    ],
    "fixtures": [
        {
            "phase": 3,
            "group": 91,
            "consumer": 6,
            "start": "2019-11-26",
            "end": "2019-12-03",
            "phase_id": 3,
            "champion_europa_fixture_id": 1084,
            "home": 6112,
            "home_team_name": "Sin Cojones",
            "home_manager": "Simon Michaelson",
            "home_manager_id": 2448,
            "home_points": 0,
            "away": 1614,
            "away_team_name": "Mina Colada",
            "away_manager": "Stuart Sims",
            "away_manager_id": 305,
            "away_points": 0,
            "gameweek": "26-11-19 to 03-12-19"
        },
        {
            "phase": 3,
            "group": 91,
            "consumer": 6,
            "start": "2019-11-26",
            "end": "2019-12-03",
            "phase_id": 3,
            "champion_europa_fixture_id": 1083,
            "home": 1713,
            "home_team_name": "Cometh the Hour, Patrick Bauer",
            "home_manager": "Brian Maynard",
            "home_manager_id": 1104,
            "home_points": 0,
            "away": 2353,
            "away_team_name": "Eventual Champions",
            "away_manager": "David Atkinson",
            "away_manager_id": 253,
            "away_points": 0,
            "gameweek": "26-11-19 to 03-12-19"
        }
    ],
    "groupStandings": [
        {
            "competition": "champion",
            "group": 2,
            "points": 15,
            "played": 6,
            "win": 5,
            "loss": 1,
            "draw": 0,
            "team_name": "Mayfair Marauders",
            "team_id": 2286,
            "manager_name": "Norman Smith",
            "PF": 74,
            "PA": 44,
            "FA": 30
        },
        {
            "competition": "champion",
            "group": 2,
            "points": 9,
            "played": 5,
            "win": 3,
            "loss": 2,
            "draw": 0,
            "team_name": "The Von Dudensteins",
            "team_id": 10669,
            "manager_name": "Gerard Ball",
            "PF": 50,
            "PA": 25,
            "FA": 25
        },
        {
            "competition": "champion",
            "group": 2,
            "points": 9,
            "played": 6,
            "win": 3,
            "loss": 3,
            "draw": 0,
            "team_name": "Oh No You Didn’t !!",
            "team_id": 4429,
            "manager_name": "Pete Button",
            "PF": 78,
            "PA": 76,
            "FA": 2
        },
        {
            "competition": "champion",
            "group": 2,
            "points": 0,
            "played": 5,
            "win": 0,
            "loss": 5,
            "draw": 0,
            "team_name": "B.B.W NO1",
            "team_id": 8503,
            "manager_name": "greig gilmour",
            "PF": 0,
            "PA": 57,
            "FA": -57
        }
    ]
}
```
----
<a name="champion_fixtures"></a>
## Champion league fixtures

This will return champion league fixtures for selected phase.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/competition/filter?phase={phase}&group={group}&competition={competition_type}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/competition/filter?phase=3&competition=champion`
|`phase`|`integer`|`required`|Ex: `/api/leagues/1/info/competition/filter?phase=3&competition=champion`
|`group`|`integer`|`optional`|Ex: `/api/leagues/1/info/competition/filter?phase=3&group=91&competition=champion`|Note: `if availbale then need to passs group else dont pass group param`

> {success} Success Response
phase fixtures
Code `200`

Content

```json
{
    "data": [
        {
            "phase": "3",
            "group": "91",
            "competition": "champion",
            "consumer": 6,
            "start": "2019-11-26",
            "end": "2019-12-03",
            "phase_id": 3,
            "champion_europa_fixture_id": 1084,
            "home": 6112,
            "home_team_name": "Sin Cojones",
            "home_manager": "Simon Michaelson",
            "home_manager_id": 2448,
            "home_points": 0,
            "away": 1614,
            "away_team_name": "Mina Colada",
            "away_manager": "Stuart Sims",
            "away_manager_id": 305,
            "away_points": 0,
            "gameweek": "26-11-19 to 03-12-19"
        },
        {
            "phase": "3",
            "group": "91",
            "competition": "champion",
            "consumer": 6,
            "start": "2019-11-26",
            "end": "2019-12-03",
            "phase_id": 3,
            "champion_europa_fixture_id": 1083,
            "home": 1713,
            "home_team_name": "Cometh the Hour, Patrick Bauer",
            "home_manager": "Brian Maynard",
            "home_manager_id": 1104,
            "home_points": 0,
            "away": 2353,
            "away_team_name": "Eventual Champions",
            "away_manager": "David Atkinson",
            "away_manager_id": 253,
            "away_points": 0,
            "gameweek": "26-11-19 to 03-12-19"
        }
    ]
}
```