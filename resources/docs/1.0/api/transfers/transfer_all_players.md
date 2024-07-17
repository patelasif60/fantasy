# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
##Get Player List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/team/{team}`|`Bearer Token`|


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
    "checkFixture": false,
    "data": [
        {
            "id": 2,
            "player_first_name": "Jermain",
            "player_last_name": "Defoe",
            "club_id": 1,
            "club_name": "AFC Bournemouth",
            "shortCode": "BOR",
            "position": "ST",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "short_code": "BOR",
            "team_player_contract_id": null,
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": 0,
            "nextFixture": "",
            "total": 0,
            "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOR/player.png"
        },
        {
            "id": 4,
            "player_first_name": "Tyrone",
            "player_last_name": "Mings",
            "club_id": 1,
            "club_name": "AFC Bournemouth",
            "shortCode": "BOR",
            "position": "CB",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "short_code": "BOR",
            "team_player_contract_id": null,
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": 0,
            "nextFixture": "",
            "total": 0,
            "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOR/player.png"
        },
        {
            "id": 5,
            "player_first_name": "Jordon",
            "player_last_name": "Ibe",
            "club_id": 1,
            "club_name": "AFC Bournemouth",
            "shortCode": "BOR",
            "position": "MF",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "short_code": "BOR",
            "team_player_contract_id": null,
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": 0,
            "nextFixture": "",
            "total": 0,
            "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOR/player.png"
        },
    ]
}
```
