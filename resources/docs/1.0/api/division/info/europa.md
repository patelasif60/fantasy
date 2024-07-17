# Europa League

---

- [Europa League Phases](#europa_phases_list)
- [Europa League Fixture](#europa_fixtures)
- [Europa Group View](#europa_group_view)

<a name="europa_phases_list"></a>
## Europa league phases

This will return list of phases for current selected league. Also return latest phase fixture detail.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/competition?competition={competition_type}`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/{division}/info/competition?competition=europa`
|`competition`|`string`|`required`|Ex: `/api/leagues/{division}/info/competition?competition=europa`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "phasesOne": [
            {
                "id": 2,
                "name": "Group stage - game 1",
                "group_no": 126,
                "start": "2019-06-01",
                "end": "2019-08-13"
            },
            {
                "id": 4,
                "name": "Group stage - game 2",
                "group_no": 126,
                "start": "2019-08-13",
                "end": "2019-08-20"
            },
            {
                "id": 6,
                "name": "Group stage - game 3",
                "group_no": 126,
                "start": "2019-08-20",
                "end": "2019-08-27"
            },
            {
                "id": 8,
                "name": "Group stage - game 4",
                "group_no": 126,
                "start": "2019-08-27",
                "end": "2019-09-03"
            },
            {
                "id": 10,
                "name": "Group stage - game 5",
                "group_no": 126,
                "start": "2019-09-10",
                "end": "2019-09-17"
            },
            {
                "id": 12,
                "name": "Group stage - game 6",
                "group_no": 126,
                "start": "2019-09-17",
                "end": "2019-09-24"
            },
            {
                "id": 14,
                "name": "Knockout stage - game 1",
                "group_no": null,
                "start": "2019-09-24",
                "end": "2019-10-01"
            }
        ],
        "FixtureOne": [
            {
                "phase": 14,
                "group": "",
                "team": 848,
                "consumer": 6,
                "start": "2019-09-24",
                "end": "2019-10-01",
                "phase_id": 14,
                "champion_europa_fixture_id": 4316,
                "home": 848,
                "home_team_name": "Winnie The Pukki",
                "home_manager": "Richard Lomas",
                "home_manager_id": 1013,
                "home_points": 8,
                "away": 846,
                "away_team_name": "Tielemans got me 5 points",
                "away_manager": "Nicholas Royal",
                "away_manager_id": 3332,
                "away_points": 19,
                "gameweek": "24-09-19 to 01-10-19"
            }
        ],
        "groupStandingsOne": [
            {
                "group": 126,
                "competition": "europa",
                "points": 15,
                "played": 6,
                "win": 5,
                "loss": 1,
                "draw": 0,
                "team_name": "Winnie The Pukki",
                "team_id": 848,
                "manager_name": "Richard Lomas",
                "PF": 80,
                "PA": 63,
                "FA": 17
            },
            {
                "group": 126,
                "competition": "europa",
                "points": 9,
                "played": 6,
                "win": 3,
                "loss": 3,
                "draw": 0,
                "team_name": "THANK YOU, EDEN",
                "team_id": 2408,
                "manager_name": "Peter Crabb",
                "PF": 82,
                "PA": 67,
                "FA": 15
            },
            {
                "group": 126,
                "competition": "europa",
                "points": 9,
                "played": 6,
                "win": 3,
                "loss": 3,
                "draw": 0,
                "team_name": "Sticky Fingers",
                "team_id": 1128,
                "manager_name": "Matt Allen",
                "PF": 76,
                "PA": 85,
                "FA": -9
            },
            {
                "group": 126,
                "competition": "europa",
                "points": 3,
                "played": 6,
                "win": 1,
                "loss": 5,
                "draw": 0,
                "team_name": "Inter Row-Z FC",
                "team_id": 10308,
                "manager_name": "Jay Ellis",
                "PF": 66,
                "PA": 89,
                "FA": -23
            }
        ],
        "phasesTwo": [
            {
                "id": 2,
                "name": "Group stage - game 1",
                "group_no": 123,
                "start": "2019-06-01",
                "end": "2019-08-13"
            },
            {
                "id": 4,
                "name": "Group stage - game 2",
                "group_no": 123,
                "start": "2019-08-13",
                "end": "2019-08-20"
            },
            {
                "id": 6,
                "name": "Group stage - game 3",
                "group_no": 123,
                "start": "2019-08-20",
                "end": "2019-08-27"
            },
            {
                "id": 8,
                "name": "Group stage - game 4",
                "group_no": 123,
                "start": "2019-08-27",
                "end": "2019-09-03"
            },
            {
                "id": 10,
                "name": "Group stage - game 5",
                "group_no": 123,
                "start": "2019-09-10",
                "end": "2019-09-17"
            },
            {
                "id": 12,
                "name": "Group stage - game 6",
                "group_no": 123,
                "start": "2019-09-17",
                "end": "2019-09-24"
            }
        ],
        "FixtureTwo": [
            {
                "phase": 12,
                "group": 123,
                "consumer": 6,
                "start": "2019-09-17",
                "end": "2019-09-24",
                "phase_id": 12,
                "champion_europa_fixture_id": 2823,
                "home": 2290,
                "home_team_name": "Andy's Devils",
                "home_manager": "Andy Smith",
                "home_manager_id": 3057,
                "home_points": 7,
                "away": 633,
                "away_team_name": "White Hart Pain",
                "away_manager": "Matthew George",
                "away_manager_id": 1438,
                "away_points": 0,
                "gameweek": "17-09-19 to 24-09-19"
            },
            {
                "phase": 12,
                "group": 123,
                "consumer": 6,
                "start": "2019-09-17",
                "end": "2019-09-24",
                "phase_id": 12,
                "champion_europa_fixture_id": 2822,
                "home": 3349,
                "home_team_name": "Daz's Rejects XI",
                "home_manager": "Tom Hible",
                "home_manager_id": 3827,
                "home_points": 14,
                "away": 5495,
                "away_team_name": "Victorious Secret",
                "away_manager": "Peter Dennis",
                "away_manager_id": 5069,
                "away_points": 3,
                "gameweek": "17-09-19 to 24-09-19"
            }
        ],
        "groupStandingsTwo": [
            {
                "group": 123,
                "competition": "europa",
                "points": 15,
                "played": 6,
                "win": 5,
                "loss": 1,
                "draw": 0,
                "team_name": "Victorious Secret",
                "team_id": 5495,
                "manager_name": "Peter Dennis",
                "PF": 73,
                "PA": 35,
                "FA": 38
            },
            {
                "group": 123,
                "competition": "europa",
                "points": 12,
                "played": 6,
                "win": 4,
                "loss": 2,
                "draw": 0,
                "team_name": "Andy's Devils",
                "team_id": 2290,
                "manager_name": "Andy Smith",
                "PF": 87,
                "PA": 62,
                "FA": 25
            },
            {
                "group": 123,
                "competition": "europa",
                "points": 9,
                "played": 6,
                "win": 3,
                "loss": 3,
                "draw": 0,
                "team_name": "Daz's Rejects XI",
                "team_id": 3349,
                "manager_name": "Tom Hible",
                "PF": 64,
                "PA": 53,
                "FA": 11
            },
            {
                "group": 123,
                "competition": "europa",
                "points": 0,
                "played": 6,
                "win": 0,
                "loss": 6,
                "draw": 0,
                "team_name": "White Hart Pain",
                "team_id": 633,
                "manager_name": "Matthew George",
                "PF": 0,
                "PA": 74,
                "FA": -74
            }
        ],
        "europaTeamOne": 848,
        "europaTeamTwo": 3349
    }
}
```
----
<a name="europa_fixtures"></a>
## Europa league fixtures

This will return europa league fixtures for selected phase.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/competition/filter?phase={phase}&group={group}&competition={competition_type}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/competition/filter?phase=2&competition=europa`
|`phase`|`integer`|`required`|Ex: `/api/leagues/1/info/competition/filter?phase=2&competition=europa`
|`team`|`integer`|`required`|Ex: `/api/leagues/1/info/competition/filter?phase=2&team=848&competition=europa`
|`group`|`integer`|`optional`|Ex: `/api/leagues/1/info/competition/filter?phase=3&group=91&team=848&competition=champion`|Note: `if availbale then need to passs group else dont pass group param`

> {success} Success Response
phase fixtures
Code `200`

Content

```json
{
    "data": [
        {
            "phase": "12",
            "group": "126",
            "team": "848",
            "competition": "europa",
            "consumer": 6,
            "start": "2019-09-17",
            "end": "2019-09-24",
            "phase_id": 12,
            "champion_europa_fixture_id": 2859,
            "home": 848,
            "home_team_name": "Winnie The Pukki",
            "home_manager": "Richard Lomas",
            "home_manager_id": 1013,
            "home_points": 7,
            "away": 2408,
            "away_team_name": "THANK YOU, EDEN",
            "away_manager": "Peter Crabb",
            "away_manager_id": 1611,
            "away_points": 2,
            "gameweek": "17-09-19 to 24-09-19"
        },
        {
            "phase": "12",
            "group": "126",
            "team": "848",
            "competition": "europa",
            "consumer": 6,
            "start": "2019-09-17",
            "end": "2019-09-24",
            "phase_id": 12,
            "champion_europa_fixture_id": 2858,
            "home": 10308,
            "home_team_name": "Inter Row-Z FC",
            "home_manager": "Jay Ellis",
            "home_manager_id": 31314,
            "home_points": 7,
            "away": 1128,
            "away_team_name": "Sticky Fingers",
            "away_manager": "Matt Allen",
            "away_manager_id": 818,
            "away_points": 21,
            "gameweek": "17-09-19 to 24-09-19"
        }
    ]
}
```


