<a name="#"></a>
## League standings team details

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{league}/standings/team?team_id={team_id}`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`team_id`|Integer|`required`|`5052` Should be a valid team id|

> {success} Success Response

Code `200`

Content

```json
{
    "players": {
        "8": {
            "total_season_points_default": "2",
            "total_season_points": "6",
            "played": "22",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "28",
            "total_clean_sheet": "4",
            "total_game_played": "22",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "0",
            "total_penalty_missed": "0",
            "total_penalty_saved": "2",
            "total_goalkeeper_save": "2",
            "total_club_win": "7",
            "team_id": 5052,
            "player_id": 650,
            "first_name": "Rui",
            "last_name": "Patricio",
            "short_code": "WOL",
            "position": "Goalkeeper (GK)",
            "club_name": "Wolverhampton Wanderers",
            "is_active": true,
            "month_points": -1,
            "week_points": 0,
            "positionOrder": 1,
            "playerPositionShort": "GK"
            "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/WOL/GK.png"
        },
        "0": {
            "total_season_points_default": "45",
            "total_season_points": "45",
            "played": "21",
            "total_goal": "2",
            "total_assist": "9",
            "total_goal_against": "14",
            "total_clean_sheet": "7",
            "total_game_played": "21",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "4",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "20",
            "team_id": 5052,
            "player_id": 371,
            "first_name": "Trent",
            "last_name": "Alexander-Arnold",
            "short_code": "LIV",
            "position": "Full-back (FB)",
            "club_name": "Liverpool",
            "is_active": true,
            "month_points": 6,
            "week_points": 0,
            "positionOrder": 2,
            "playerPositionShort": "FB"
            "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/LIV/player.png"
        },
        "2": {
            "total_season_points_default": "3",
            "total_season_points": "3",
            "played": "18",
            "total_goal": "3",
            "total_assist": "4",
            "total_goal_against": "20",
            "total_clean_sheet": "3",
            "total_game_played": "18",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "1",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "6",
            "team_id": 5052,
            "player_id": 640,
            "first_name": "Matt",
            "last_name": "Doherty",
            "short_code": "WOL",
            "position": "Full-back (FB)",
            "club_name": "Wolverhampton Wanderers",
            "is_active": true,
            "month_points": 3,
            "week_points": 0,
            "positionOrder": 2,
            "playerPositionShort": "FB"
            "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/WOL/player.png"
        },
        ...
    }
}
```
