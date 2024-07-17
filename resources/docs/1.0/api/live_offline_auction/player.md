# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
##Get Player List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/team/{team}`|`Bearer Token`|


### Data Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`position`|String|`optional`|Ex:`ST`|
|`club`|Integer|`optional`|Ex:`1`|
|`player`|String|`optional`|Ex:`Jermain`|
|`boughtPlayers`|Enum|`optional`|Ex:`yes` or `no`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": [
        "players": [
            {
                "id": 37,
                "player_first_name": "Bernd",
                "player_last_name": "Leno",
                "player_short_code": "124",
                "club_id": 2,
                "club_name": "Arsenal",
                "position": "GK",
                "merge_positions": "Goalkeeper (GK)",
                "team_id": 11875,
                "team_name": "Team 1 -Live offline test api",
                "user_first_name": "Matt",
                "user_last_name": "Sims",
                "bid": "2.00",
                "short_code": "ARS",
                "team_player_contract_id": 817203,
                "total_game_played": "32",
                "total": 2,
                "playerPositionFull": "Goalkeeper (GK)"
            },
            {
                "id": 41,
                "player_first_name": "Emiliano",
                "player_last_name": "Martinez",
                "player_short_code": "101",
                "club_id": 2,
                "club_name": "Arsenal",
                "position": "GK",
                "merge_positions": "Goalkeeper (GK)",
                "team_id": 11875,
                "team_name": "Team 1 -Live offline test api",
                "user_first_name": "Matt",
                "user_last_name": "Sims",
                "bid": "3.00",
                "short_code": "ARS",
                "team_player_contract_id": 817204,
                "total_game_played": "0",
                "total": 0,
                "playerPositionFull": "Goalkeeper (GK)"
            }
        ],
        "clubs": [
            {
                "id": 2,
                "name": "Arsenal",
                "short_code": "ARS"
            },
            {
                "id": 48,
                "name": "Aston Villa",
                "short_code": "AV"
            },
            {
                "id": 3,
                "name": "Brighton & Hove Albion",
                "short_code": "BHA"
            },
            {
                "id": 1,
                "name": "AFC Bournemouth",
                "short_code": "BOU"
            },
            {
                "id": 4,
                "name": "Burnley",
                "short_code": "BUR"
            },
            {
                "id": 6,
                "name": "Chelsea",
                "short_code": "CHE"
            },
            {
                "id": 7,
                "name": "Crystal Palace",
                "short_code": "CP"
            },
            {
                "id": 8,
                "name": "Everton",
                "short_code": "EVE"
            },
            {
                "id": 11,
                "name": "Leicester City",
                "short_code": "LEI"
            },
            {
                "id": 12,
                "name": "Liverpool",
                "short_code": "LIV"
            },
            {
                "id": 13,
                "name": "Manchester City",
                "short_code": "MC"
            },
            {
                "id": 14,
                "name": "Manchester United",
                "short_code": "MU"
            },
            {
                "id": 15,
                "name": "Newcastle United",
                "short_code": "NEW"
            },
            {
                "id": 49,
                "name": "Norwich City",
                "short_code": "NOR"
            },
            {
                "id": 16,
                "name": "Southampton",
                "short_code": "SOT"
            },
            {
                "id": 50,
                "name": "Sheffield United",
                "short_code": "SU"
            },
            {
                "id": 17,
                "name": "Tottenham Hotspur",
                "short_code": "TOT"
            },
            {
                "id": 18,
                "name": "Watford",
                "short_code": "WAT"
            },
            {
                "id": 19,
                "name": "West Ham United",
                "short_code": "WH"
            },
            {
                "id": 20,
                "name": "Wolverhampton Wanderers",
                "short_code": "WOL"
            }
        ]
    ]
}
```
