# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Free Agents](#free_agents)

<a name="free_agents"></a>
## Free Agents List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/transfers/get_free_agents`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`position`|`string`|`optional`|Ex: `Goalkeeper (GK)`
|`club`|`integer`|`optional`|Ex: `1`
|`start`|`string`|`optional`|Ex: `50`|Note:`For first time call only`
|`length`|`string`|`required`|Ex: `2`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "draw": 0,
        "recordsTotal": 325,
        "recordsFiltered": 325,
        "data": [
            {
                "id": "4",
                "player_first_name": "Tyrone",
                "player_last_name": "Mings",
                "club_id": "48",
                "club_name": "AV",
                "player_status": null,
                "position": "<div class=\"player-wrapper js-player-details cursor-pointer\" data-id=\"4\" data-name=\"Tyrone Mings\" data-club=\"AV\"><div><span class=\"custom-badge custom-badge-lg is-square is-cb\">CB</span></div><div> <div class=\"player-tshirt icon-18 av_player mr-1\"></div>T. Mings  </div>",
                "team_id": null,
                "team_name": null,
                "user_first_name": null,
                "user_last_name": null,
                "bid": null,
                "short_code": "AV",
                "team_player_contract_id": null,
                "total_goal": "2",
                "total_assist": "1",
                "total_goal_against": "34",
                "total_clean_sheet": "3",
                "total_game_played": "19",
                "total_own_goal": 0,
                "total_red_card": 0,
                "total_yellow_card": 0,
                "total_penalty_missed": 0,
                "total_penalty_saved": 0,
                "total_goalkeeper_save": 0,
                "total_club_win": 0,
                "weekPoint": 0,
                "monthPoint": 0,
                "total": "-1",
                "original_position": "CB",
                "positionOrder": "3",
                "team_manager_name": "<div class=\"player-wrapper\"><div><div></div><div class=\"small\"> </div></div></div>"
            },
            {
                "id": "5",
                "player_first_name": "Jordon",
                "player_last_name": "Ibe",
                "club_id": "1",
                "club_name": "BOU",
                "player_status": null,
                "position": "<div class=\"player-wrapper js-player-details cursor-pointer\" data-id=\"5\" data-name=\"Jordon Ibe\" data-club=\"BOU\"><div><span class=\"custom-badge custom-badge-lg is-square is-mf\">MF</span></div><div> <div class=\"player-tshirt icon-18 bou_player mr-1\"></div>J. Ibe  </div>",
                "team_id": null,
                "team_name": null,
                "user_first_name": null,
                "user_last_name": null,
                "bid": null,
                "short_code": "BOU",
                "team_player_contract_id": null,
                "total_goal": "0",
                "total_assist": "0",
                "total_goal_against": 0,
                "total_clean_sheet": 0,
                "total_game_played": "0",
                "total_own_goal": 0,
                "total_red_card": 0,
                "total_yellow_card": 0,
                "total_penalty_missed": 0,
                "total_penalty_saved": 0,
                "total_goalkeeper_save": 0,
                "total_club_win": 0,
                "weekPoint": 0,
                "monthPoint": 0,
                "total": 0,
                "original_position": "MF",
                "positionOrder": "7",
                "team_manager_name": "<div class=\"player-wrapper\"><div><div></div><div class=\"small\"> </div></div></div>"
            }
        ]
    }
}
```
