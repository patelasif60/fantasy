# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Get All Players](#get_all_players)

<a name="get_all_players"></a>
## Get All Players

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/transfers/swaps/get_all_players`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "checkFixture": false,
    "data": [
        {
            "player_first_name": "Bernd",
            "player_last_name": "Leno",
            "player_id": 36,
            "club_id": 2,
            "club_short_code": "ARS",
            "position": "GK",
            "team_id": 174,
            "team_name": "Team One",
            "manager_first_name": "Ben",
            "manager_last_name": "Grout",
            "team_budget": "386.00"
        },
        {
            "player_first_name": "Jason",
            "player_last_name": "Steele",
            "player_id": 74,
            "club_id": 3,
            "club_short_code": "BRI",
            "position": "GK",
            "team_id": 174,
            "team_name": "Team One",
            "manager_first_name": "Ben",
            "manager_last_name": "Grout",
            "team_budget": "386.00"
        }
    ]
}
```
