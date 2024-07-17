# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Players

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`api/league/{division}/transfers/sealed/bids/{team}/data/json/players`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|
|:-|:-|:-|
|`position`|String||`ST` Player position |
|`name`|String||`Harry`  Player name |
|`club`|Integer||`1` Club Id|
|`bought_player`|String||`yes` yes or no |
|`is_mobile`|Boolean||`true` |

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "playerId": 866,
            "playerFirstName": null,
            "playerLastName": "Joelinton",
            "playerPosition": "Striker (ST)",
            "playerClubName": "Newcastle United",
            "playerClubId": 15,
            "playerClubShortCode": "NEW",
            "total_goal": "1",
            "total_assist": "2",
            "total_goal_against": "31",
            "total_clean_sheet": "4",
            "total_game_played": "23",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "4",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "7",
            "soldPlayerTeamId": 2433,
            "soldPlayerTeamName": "Planck's Constants",
            "soldPlayerTransferValue": "0.00",
            "total_points": 7,
            "playerPositionShort": "ST",
            "positionOrder": 8
        },
        {
            "playerId": 378,
            "playerFirstName": null,
            "playerLastName": "Alisson",
            "playerPosition": "Goalkeeper (GK)",
            "playerClubName": "Liverpool",
            "playerClubId": 12,
            "playerClubShortCode": "LIV",
            "total_goal": "0",
            "total_assist": "1",
            "total_goal_against": "5",
            "total_clean_sheet": "8",
            "total_game_played": "13",
            "total_own_goal": "0",
            "total_red_card": "1",
            "total_yellow_card": "0",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "1",
            "total_club_win": "12",
            "soldPlayerTeamId": 4629,
            "soldPlayerTeamName": "V.A.R my Lord FC",
            "soldPlayerTransferValue": "12.50",
            "total_points": 26,
            "playerPositionShort": "GK",
            "positionOrder": 1
        },
        {
            "playerId": 504,
            "playerFirstName": null,
            "playerLastName": "Joselu",
            "playerPosition": "Striker (ST)",
            "playerClubName": "Newcastle United",
            "playerClubId": 15,
            "playerClubShortCode": "NEW",
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": "0",
            "total_own_goal": null,
            "total_red_card": null,
            "total_yellow_card": null,
            "total_penalty_missed": null,
            "total_penalty_saved": null,
            "total_goalkeeper_save": null,
            "total_club_win": null,
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": 0,
            "playerPositionShort": "ST",
            "positionOrder": 8
        },
        {
            "playerId": 605,
            "playerFirstName": null,
            "playerLastName": "Adrian",
            "playerPosition": "Goalkeeper (GK)",
            "playerClubName": "Liverpool",
            "playerClubId": 12,
            "playerClubShortCode": "LIV",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "9",
            "total_clean_sheet": "2",
            "total_game_played": "9",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "1",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "9",
            "soldPlayerTeamId": 2434,
            "soldPlayerTeamName": "My Little Pony",
            "soldPlayerTransferValue": "1.00",
            "total_points": 4,
            "playerPositionShort": "GK",
            "positionOrder": 1
        },
        {
            "playerId": 692,
            "playerFirstName": null,
            "playerLastName": "Jota",
            "playerPosition": "Midfielder (MF)",
            "playerClubName": "Aston Villa",
            "playerClubId": 48,
            "playerClubShortCode": "AV",
            "total_goal": "0",
            "total_assist": "1",
            "total_goal_against": "4",
            "total_clean_sheet": "1",
            "total_game_played": "4",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "0",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "1",
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": 2,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 264,
            "playerFirstName": null,
            "playerLastName": "Richarlison",
            "playerPosition": "Midfielder (MF)",
            "playerClubName": "Everton",
            "playerClubId": 8,
            "playerClubShortCode": "EVE",
            "total_goal": "8",
            "total_assist": "4",
            "total_goal_against": "31",
            "total_clean_sheet": "5",
            "total_game_played": "22",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "4",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "8",
            "soldPlayerTeamId": 3991,
            "soldPlayerTeamName": "Bentleys XI",
            "soldPlayerTransferValue": "17.00",
            "total_points": 32,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 81,
            "playerFirstName": null,
            "playerLastName": "Bernardo",
            "playerPosition": "Full-back (FB)",
            "playerClubName": "Brighton & Hove Albion",
            "playerClubId": 3,
            "playerClubShortCode": "BHA",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "9",
            "total_clean_sheet": "0",
            "total_game_played": "6",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "1",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "0",
            "soldPlayerTeamId": 3974,
            "soldPlayerTeamName": "Frankie and Connor Rangers",
            "soldPlayerTransferValue": "0.00",
            "total_points": -3,
            "playerPositionShort": "FB",
            "positionOrder": 2
        },
        {
            "playerId": 268,
            "playerFirstName": null,
            "playerLastName": "Bernard",
            "playerPosition": "Midfielder (MF)",
            "playerClubName": "Everton",
            "playerClubId": 8,
            "playerClubShortCode": "EVE",
            "total_goal": "2",
            "total_assist": "2",
            "total_goal_against": "7",
            "total_clean_sheet": "5",
            "total_game_played": "11",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "2",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "4",
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": 10,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 408,
            "playerFirstName": null,
            "playerLastName": "Ederson",
            "playerPosition": "Goalkeeper (GK)",
            "playerClubName": "Manchester City",
            "playerClubId": 13,
            "playerClubShortCode": "MC",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "20",
            "total_clean_sheet": "7",
            "total_game_played": "20",
            "total_own_goal": "0",
            "total_red_card": "1",
            "total_yellow_card": "3",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "4",
            "total_club_win": "14",
            "soldPlayerTeamId": 2437,
            "soldPlayerTeamName": "The Lego Knights",
            "soldPlayerTransferValue": "16.00",
            "total_points": 14,
            "playerPositionShort": "GK",
            "positionOrder": 1
        },
        {
            "playerId": 793,
            "playerFirstName": null,
            "playerLastName": "Roberto",
            "playerPosition": "Goalkeeper (GK)",
            "playerClubName": "West Ham United",
            "playerClubId": 19,
            "playerClubShortCode": "WH",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "17",
            "total_clean_sheet": "0",
            "total_game_played": "8",
            "total_own_goal": "1",
            "total_red_card": "0",
            "total_yellow_card": "0",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "4",
            "total_club_win": "0",
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": -9,
            "playerPositionShort": "GK",
            "positionOrder": 1
        },
        {
            "playerId": 864,
            "playerFirstName": null,
            "playerLastName": "Trezeguet",
            "playerPosition": "Midfielder (MF)",
            "playerClubName": "Aston Villa",
            "playerClubId": 48,
            "playerClubShortCode": "AV",
            "total_goal": "3",
            "total_assist": "2",
            "total_goal_against": "20",
            "total_clean_sheet": "3",
            "total_game_played": "14",
            "total_own_goal": "0",
            "total_red_card": "1",
            "total_yellow_card": "2",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "4",
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": 13,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 181,
            "playerFirstName": null,
            "playerLastName": "Emerson",
            "playerPosition": "Full-back (FB)",
            "playerClubName": "Chelsea",
            "playerClubId": 6,
            "playerClubShortCode": "CHE",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "21",
            "total_clean_sheet": "1",
            "total_game_played": "11",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "3",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "3",
            "soldPlayerTeamId": 2432,
            "soldPlayerTeamName": "Accrington Sonley",
            "soldPlayerTransferValue": "2.00",
            "total_points": -8,
            "playerPositionShort": "FB",
            "positionOrder": 2
        },
        {
            "playerId": 423,
            "playerFirstName": null,
            "playerLastName": "Danilo",
            "playerPosition": "Full-back (FB)",
            "playerClubName": "Manchester City",
            "playerClubId": 13,
            "playerClubShortCode": "MC",
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": "0",
            "total_own_goal": null,
            "total_red_card": null,
            "total_yellow_card": null,
            "total_penalty_missed": null,
            "total_penalty_saved": null,
            "total_goalkeeper_save": null,
            "total_club_win": null,
            "soldPlayerTeamId": 3321,
            "soldPlayerTeamName": "Juvetude FC",
            "soldPlayerTransferValue": "0.10",
            "total_points": 0,
            "playerPositionShort": "FB",
            "positionOrder": 2
        },
        {
            "playerId": 378,
            "playerFirstName": null,
            "playerLastName": "Alisson",
            "playerPosition": "Goalkeeper (GK)",
            "playerClubName": "Liverpool",
            "playerClubId": 12,
            "playerClubShortCode": "LIV",
            "total_goal": "0",
            "total_assist": "1",
            "total_goal_against": "5",
            "total_clean_sheet": "8",
            "total_game_played": "13",
            "total_own_goal": "0",
            "total_red_card": "1",
            "total_yellow_card": "0",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "1",
            "total_club_win": "12",
            "soldPlayerTeamId": 9506,
            "soldPlayerTeamName": "Mandem Utd",
            "soldPlayerTransferValue": "10.00",
            "total_points": 26,
            "playerPositionShort": "GK",
            "positionOrder": 1
        },
        {
            "playerId": 198,
            "playerFirstName": null,
            "playerLastName": "Pedro",
            "playerPosition": "Midfielder (MF)",
            "playerClubName": "Chelsea",
            "playerClubId": 6,
            "playerClubShortCode": "CHE",
            "total_goal": "0",
            "total_assist": "0",
            "total_goal_against": "6",
            "total_clean_sheet": "0",
            "total_game_played": "4",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "0",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "1",
            "soldPlayerTeamId": 2431,
            "soldPlayerTeamName": "Turdagain FFS",
            "soldPlayerTransferValue": "16.00",
            "total_points": 0,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 681,
            "playerFirstName": null,
            "playerLastName": "Wesley",
            "playerPosition": "Striker (ST)",
            "playerClubName": "Aston Villa",
            "playerClubId": 48,
            "playerClubShortCode": "AV",
            "total_goal": "5",
            "total_assist": "1",
            "total_goal_against": "31",
            "total_clean_sheet": "5",
            "total_game_played": "21",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "3",
            "total_penalty_missed": "1",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "6",
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": 17,
            "playerPositionShort": "ST",
            "positionOrder": 8
        },
        {
            "playerId": 720,
            "playerFirstName": null,
            "playerLastName": "Angelino",
            "playerPosition": "Full-back (FB)",
            "playerClubName": "Manchester City",
            "playerClubId": 13,
            "playerClubShortCode": "MC",
            "total_goal": "0",
            "total_assist": "1",
            "total_goal_against": "7",
            "total_clean_sheet": "0",
            "total_game_played": "5",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "1",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "2",
            "soldPlayerTeamId": 5686,
            "soldPlayerTeamName": "Josies Jesters",
            "soldPlayerTransferValue": "37.00",
            "total_points": 0,
            "playerPositionShort": "FB",
            "positionOrder": 2
        },
        {
            "playerId": 188,
            "playerFirstName": null,
            "playerLastName": "Jorginho",
            "playerPosition": "Defensive Midfielder (DMF)",
            "playerClubName": "Chelsea",
            "playerClubId": 6,
            "playerClubShortCode": "CHE",
            "total_goal": "4",
            "total_assist": "2",
            "total_goal_against": "25",
            "total_clean_sheet": "4",
            "total_game_played": "20",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "8",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "9",
            "soldPlayerTeamId": null,
            "soldPlayerTeamName": null,
            "soldPlayerTransferValue": null,
            "total_points": 16,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 191,
            "playerFirstName": null,
            "playerLastName": "Willian",
            "playerPosition": "Midfielder (MF)",
            "playerClubName": "Chelsea",
            "playerClubId": 6,
            "playerClubShortCode": "CHE",
            "total_goal": "4",
            "total_assist": "5",
            "total_goal_against": "18",
            "total_clean_sheet": "5",
            "total_game_played": "19",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "2",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "11",
            "soldPlayerTeamId": 9506,
            "soldPlayerTeamName": "Mandem Utd",
            "soldPlayerTransferValue": "2.00",
            "total_points": 22,
            "playerPositionShort": "MF",
            "positionOrder": 7
        },
        {
            "playerId": 722,
            "playerFirstName": null,
            "playerLastName": "Rodri",
            "playerPosition": "Defensive Midfielder (DMF)",
            "playerClubName": "Manchester City",
            "playerClubId": 13,
            "playerClubShortCode": "MC",
            "total_goal": "2",
            "total_assist": "1",
            "total_goal_against": "21",
            "total_clean_sheet": "7",
            "total_game_played": "18",
            "total_own_goal": "0",
            "total_red_card": "0",
            "total_yellow_card": "5",
            "total_penalty_missed": "0",
            "total_penalty_saved": "0",
            "total_goalkeeper_save": "0",
            "total_club_win": "12",
            "soldPlayerTeamId": 5837,
            "soldPlayerTeamName": "Huntsea FC",
            "soldPlayerTransferValue": "44.00",
            "total_points": 8,
            "playerPositionShort": "MF",
            "positionOrder": 7
        }
    ]
}
```