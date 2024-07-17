# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
##Team Player List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|` /api/division/{division}/transfers/get_who_owns_who_players `|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`start`|`integer`|`valid start record position`|Ex: `11`
|`length`|`integer`|`valid numeric length of records`|Ex: `2`

### Success response

```json
{
    "columns": {
        "goal": 6,
        "assist": 6,
        "goal_conceded": 3,
        "clean_sheet": 3,
        "appearance": 3,
        "club_win": 1,
        "red_card": 1,
        "yellow_card": 1,
        "own_goal": 1,
        "penalty_missed": 1,
        "penalty_save": 1,
        "goalkeeper_save_x5": 1
    },
    "data": [
        {
            "id": "9",
            "player_first_name": "Callum",
            "player_last_name": "Wilson",
            "club_id": "1",
            "club_name": "BOU",
            "player_status": null,
            "position": "<div class=\"player-wrapper js-player-details cursor-pointer\" data-id=\"9\" data-name=\"Callum Wilson\" data-club=\"BOU\"><div><span class=\"custom-badge custom-badge-lg is-square is-st\">ST</span></div><div><div>C. Wilson</div></div>",
            "team_id": "9097",
            "team_name": "Gareth Bale&#039;s Hotscotts",
            "user_first_name": "Fantasy",
            "user_last_name": "League",
            "bought_price": "35.00",
            "short_code": "BOU",
            "team_player_contract_id": "422897",
            "total_goal": "6",
            "total_assist": "2",
            "total_goal_against": 0,
            "total_clean_sheet": 0,
            "total_game_played": "22",
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 0,
            "total": "22",
            "original_position": "ST",
            "positionOrder": "8",
            "m_tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOU/player.png",
            "m_position": "ST",
            "team_manager_name": "Fantasy League"
        },
        {
            "id": "12",
            "player_first_name": "Ryan",
            "player_last_name": "Fraser",
            "club_id": "1",
            "club_name": "BOU",
            "player_status": null,
            "position": "<div class=\"player-wrapper js-player-details cursor-pointer\" data-id=\"12\" data-name=\"Ryan Fraser\" data-club=\"BOU\"><div><span class=\"custom-badge custom-badge-lg is-square is-mf\">MF</span></div><div><div>R. Fraser</div></div>",
            "team_id": "1661",
            "team_name": "Who&#039;s Who of Poo.",
            "user_first_name": "Fantasy",
            "user_last_name": "League",
            "bought_price": "10.00",
            "short_code": "BOU",
            "team_player_contract_id": "23090",
            "total_goal": "1",
            "total_assist": "3",
            "total_goal_against": 0,
            "total_clean_sheet": 0,
            "total_game_played": "18",
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 0,
            "total": "9",
            "original_position": "MF",
            "positionOrder": "7",
            "m_tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOU/player.png",
            "m_position": "MF",
            "team_manager_name": "Fantasy League"
        }
    ]
}
```
