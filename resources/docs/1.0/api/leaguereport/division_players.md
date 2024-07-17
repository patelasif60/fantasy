# League Players API Docs

---
- [Filters](#league_filter_data)
- [League players list](#league_players_list)

<a name="league_filter_data"></a>
## Filters

This will return list of positions and clubs.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/report/league/data`|`Bearer Token`|

### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "positions": [
        "Goalkeeper (GK)",
        "Full-back (FB)",
        "Centre-back (CB)",
        "Defensive Midfielder (DMF)",
        "Midfielder (MF)",
        "Striker (ST)"
    ],
    "clubs": [
        {
            "id": 1,
            "name": "AFC Bournemouth"
        },
        {
            "id": 2,
            "name": "Arsenal"
        },
        {
            "id": 3,
            "name": "Brighton & Hove Albion"
        }, 
    ]
}
```

<a name="league_players_list"></a>
## League players list

This will return list of players under league.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/report/league/{league}/players`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`league`|`integer`|`required`|Ex: `1`

### DATA Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`position`|`Enum`|`optional`|Ex: `Goalkeeper (GK)`
|`club_id`|`integer`|`optional`|Ex: 1
|`page`|`integer`|`optional`|Ex: 1
> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "position": "GK",
            "player_first_name": "Alexandra",
            "player_last_name": "Leuschke",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Wingate & Finchley FC",
            "team_name": "Predovicland United",
            "transfer_value": "0.00",
            "goal": 2,
            "assist": 2,
            "clean_sheet": 0,
            "conceded": 22,
            "appearance": 2,
            "total": 2
        },
        {
            "position": "GK",
            "player_first_name": "Alexandra",
            "player_last_name": "Leuschke",
            "manager_first_name": "MohamadFarjan",
            "manager_last_name": "Daudiya",
            "club_name": "Wingate & Finchley FC",
            "team_name": "Sengerchester FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Althea",
            "player_last_name": "Corwin",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Fairford Town FC",
            "team_name": "Predovicland United",
            "transfer_value": "0.00",
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Althea",
            "player_last_name": "Corwin",
            "manager_first_name": "Sunny",
            "manager_last_name": "Sheth",
            "club_name": "Fairford Town FC",
            "team_name": "Alexieton FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Alysson",
            "player_last_name": "Borer",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Huddersfield Town FC",
            "team_name": "Ortizburgh Football",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Amely",
            "player_last_name": "Dibbert",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Market Drayton Town FC",
            "team_name": "Predovicland United",
            "transfer_value": "0.00",
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Amely",
            "player_last_name": "Dibbert",
            "manager_first_name": "Sunny",
            "manager_last_name": "Sheth",
            "club_name": "Market Drayton Town FC",
            "team_name": "Alexieton FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "ST",
            "player_first_name": "Amparo",
            "player_last_name": "Wilkinson",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Sandbach United FC",
            "team_name": "Ortizburgh Football",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "GK",
            "player_first_name": "Angeline",
            "player_last_name": "Ledner",
            "manager_first_name": "Sunny",
            "manager_last_name": "Sheth",
            "club_name": "Liverpool FC",
            "team_name": "Alexieton FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Arlene",
            "player_last_name": "Emard",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Shepton Mallet AFC",
            "team_name": "Ortizburgh Football",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Athena",
            "player_last_name": "Dibbert",
            "manager_first_name": "Jayprakash",
            "manager_last_name": "Jangir",
            "club_name": "Odd Down AFC",
            "team_name": "Alvisshire United",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "GK",
            "player_first_name": "Barton",
            "player_last_name": "Herman",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Dagenham & Redbridge FC",
            "team_name": "Predovicland United",
            "transfer_value": "0.00",
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "GK",
            "player_first_name": "Barton",
            "player_last_name": "Herman",
            "manager_first_name": "MohamadFarjan",
            "manager_last_name": "Daudiya",
            "club_name": "Dagenham & Redbridge FC",
            "team_name": "Sengerchester FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "GK",
            "player_first_name": "Bernardo",
            "player_last_name": "Padberg",
            "manager_first_name": "MohamadFarjan",
            "manager_last_name": "Daudiya",
            "club_name": "Boreham Wood FC",
            "team_name": "Sengerchester FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "CB",
            "player_first_name": "Beulah",
            "player_last_name": "McClure",
            "manager_first_name": "Jayprakash",
            "manager_last_name": "Jangir",
            "club_name": "Norwich United",
            "team_name": "Alvisshire United",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "ST",
            "player_first_name": "Branson",
            "player_last_name": "Maggio",
            "manager_first_name": "MohamadFarjan",
            "manager_last_name": "Daudiya",
            "club_name": "Framlingham Town FC",
            "team_name": "Sengerchester FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "GK",
            "player_first_name": "Brianne",
            "player_last_name": "Paucek",
            "manager_first_name": "fname",
            "manager_last_name": "lname",
            "club_name": "Maltby Main",
            "team_name": "Jordymouth FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "CB",
            "player_first_name": "Caroline",
            "player_last_name": "Fahey",
            "manager_first_name": "register",
            "manager_last_name": "user",
            "club_name": "Pinchbeck United FC",
            "team_name": "Ortizburgh Football",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "FB",
            "player_first_name": "Carolyn",
            "player_last_name": "Wyman",
            "manager_first_name": "Farzan",
            "manager_last_name": "Daudiya",
            "club_name": "Leicester City FC",
            "team_name": "West Lonny Football",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "ST",
            "player_first_name": "Charlotte",
            "player_last_name": "Buckridge",
            "manager_first_name": "MohamadFarjan",
            "manager_last_name": "Daudiya",
            "club_name": "Broadbridge Heath FC",
            "team_name": "Sengerchester FC",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        }
    ],
    "links": {
        "first": "http://irfan-fantasyleague.dev.aecortech.com/api/report/league/1/players?page=1",
        "last": "http://irfan-fantasyleague.dev.aecortech.com/api/report/league/1/players?page=4",
        "prev": null,
        "next": "http://irfan-fantasyleague.dev.aecortech.com/api/report/league/1/players?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 4,
        "path": "http://irfan-fantasyleague.dev.aecortech.com/api/report/league/1/players",
        "per_page": 20,
        "to": 20,
        "total": 66
    }
}
```
