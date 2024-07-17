# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Get Team Players](#get_team_players)

<a name="get_team_players"></a>
## Get Team Players

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/team/{team}/swaps/getTeamPlayers`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`
|`team`|`integer`|`valid numeric team id`|Ex: `1`


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "checkFixture": false,
    "data": [
        {
            "player_first_name": "David",
            "player_last_name": "de Gea",
            "player_id": 470,
            "club_id": 14,
            "club_short_code": "MU",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Hector",
            "player_last_name": "Bellerin",
            "player_id": 39,
            "club_id": 2,
            "club_short_code": "ARS",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Brandon",
            "player_last_name": "Williams",
            "player_id": 946,
            "club_id": 14,
            "club_short_code": "MU",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Reece",
            "player_last_name": "James",
            "player_id": 706,
            "club_id": 6,
            "club_short_code": "CHE",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Mason",
            "player_last_name": "Holgate",
            "player_id": 248,
            "club_id": 8,
            "club_short_code": "EVE",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Caglar",
            "player_last_name": "Soyuncu",
            "player_id": 362,
            "club_id": 11,
            "club_short_code": "LEI",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Jan",
            "player_last_name": "Vertonghen",
            "player_id": 552,
            "club_id": 17,
            "club_short_code": "TOT",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Ayoze",
            "player_last_name": "Perez",
            "player_id": 505,
            "club_id": 11,
            "club_short_code": "LEI",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Pascal",
            "player_last_name": "Gross",
            "player_id": 76,
            "club_id": 3,
            "club_short_code": "BHA",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Callum",
            "player_last_name": "Hudson-Odoi",
            "player_id": 178,
            "club_id": 6,
            "club_short_code": "CHE",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Lucas",
            "player_last_name": "Moura",
            "player_id": 556,
            "club_id": 17,
            "club_short_code": "TOT",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Miguel",
            "player_last_name": "Almiron",
            "player_id": 499,
            "club_id": 15,
            "club_short_code": "NEW",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Danny",
            "player_last_name": "Ings",
            "player_id": 527,
            "club_id": 16,
            "club_short_code": "SOT",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Chris",
            "player_last_name": "Wood",
            "player_id": 133,
            "club_id": 4,
            "club_short_code": "BUR",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        },
        {
            "player_first_name": "Sergio",
            "player_last_name": "Aguero",
            "player_id": 417,
            "club_id": 13,
            "club_short_code": "MC",
            "position": "",
            "team_id": 1617,
            "team_name": "The Moura, The Merrier",
            "manager_first_name": "Matt",
            "manager_last_name": "Sims",
            "team_budget": "7.80"
        }
    ]
}
```
