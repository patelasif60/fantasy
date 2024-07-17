# Pro Cup Fixture API 

---

- [Pro Cup Phases](#phase_list)
- [Phase Fixture](#phase_fixtures)

<a name="phase_list"></a>
## Pro cup phases

This will return list of phases for current selected league. Also return latest phase fixture detail.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/phases`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/phases`

> {success} Success Response

Code `200`

Content

```json
{
    "phases": {
        "8": "Phase 1",
        "12": "Phase 2",
        "16": "Phase 3",
        "20": "Phase 4",
        "24": "Phase 5"
    },
    "latestPhaseFixture": [
        {
            "phase_id": 24,
            "procup_fixture_id": 214,
            "gameweek_start": "2019-03-26",
            "gameweek_end": "2019-04-02",
            "gameweek": "26th March - 2nd April 2019",
            "away_team_id": 50,
            "away_team_name": "Jameson Fire Thunderballs",
            "away_points": null,
            "away_manager": "Conrad Jerde",
            "home_team_id": 33,
            "home_team_name": "Roderick Hurricanes",
            "home_manager": "Sallie Reilly",
            "home_points": null
        }
    ],
    "message": "Pro cup fixtures"
}
```
----
<a name="phase_fixtures"></a>
## Phase fixtures

This will return fixtures for pass phase id.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/info/pro_cup/filter?phase={phase}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/leagues/1/info/pro_cup/filter?phase=1`
|`phase`|`integer`|`required`|Ex: `/api/leagues/1/info/pro_cup/filter?phase=1`

> {success} Success Response
phase fixtures
Code `200`

Content

```json
{
    "data": [
        {
            "phase_id": 24,
            "procup_fixture_id": 214,
            "gameweek_start": "2019-03-26",
            "gameweek_end": "2019-04-02",
            "gameweek": "26th March - 2nd April 2019",
            "away_team_id": 50,
            "away_team_name": "Jameson Fire Thunderballs",
            "away_points": null,
            "away_manager": "Conrad Jerde",
            "home_team_id": 33,
            "home_team_name": "Roderick Hurricanes",
            "home_manager": "Sallie Reilly",
            "home_points": null
        }
    ]
}
```

Note

Pass phase key from first api "/api/leagues/{division}/info/phases" call response to get phase fixtures.