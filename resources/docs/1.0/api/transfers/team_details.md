# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
##Team Player List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|` /api/division/{division}/transfers/teams/{team}/team_details `|`Bearer Token`|


### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "team": {
            "id": 138,
            "name": "Ben 1's Team",
            "manager_id": 33,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "64c1b537-c818-444e-b808-c54488ffe16e",
            "team_budget": "159.00",
            "created_at": "2019-04-25 09:38:12",
            "updated_at": "2019-05-28 07:46:30",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/2/conversions/ebd4e26a25fba430a617378d0ef1895f-thumb.jpg",
            "defaultSquadSize": 15,
            "team_players_count": 31
        },
        "teamClubsPlayer": {
            "1": 3,
            "2": 2,
            "3": 2,
            "4": 1,
            "5": 2,
            "8": 2,
            "9": 1
        },
        "maxClubPlayers": 3,
        "mergeDefenders": "Yes",
        "defensiveMidfields": "No",
        "availablePostions": [
            "GK",
            "MF",
            "ST",
            "DF"
        ],
        "clubs": {
            "1": "AFC Bournemouth",
            "2": "Arsenal",
            "3": "Brighton & Hove Albion",
            "4": "Burnley",
            "5": "Cardiff City",
            "6": "Chelsea",
            "7": "Crystal Palace",
            "8": "Everton",
            "9": "Fulham",
            "10": "Huddersfield Town",
            "11": "Leicester City",
            "12": "Liverpool",
            "13": "Manchester City",
            "14": "Manchester United",
            "15": "Newcastle United",
            "16": "Southampton",
            "17": "Tottenham Hotspur",
            "18": "Watford",
            "19": "West Ham United",
            "20": "Wolverhampton Wanderers",
            "21": "Millwall FC",
            "22": "Swansea City AFC",
            "23": "Doncaster Rovers FC",
            "24": "Bristol City FC",
            "25": "Newport County AFC",
            "26": "Derby County FC",
            "27": "Queens Park Rangers FC",
            "28": "West Bromwich Albion FC",
            "29": "Shrewsbury Town FC",
            "30": "Sheffield Wednesday FC",
            "31": "AFC Wimbledon",
            "32": "Shrewsbury Town FC",
            "33": "Derby County FC",
            "34": "Blackburn Rovers FC",
            "35": "Woking FC",
            "36": "Rotherham United FC",
            "37": "Oldham Athletic AFC",
            "38": "Grimsby Town FC",
            "39": "Blackpool FC",
            "40": "Nottingham Forest FC",
            "41": "Derby County FC",
            "42": "Lincoln City FC",
            "43": "Gillingham FC",
            "44": "Reading FC",
            "45": "Barnsley FC",
            "46": "Birmingham City FC",
            "47": "Tranmere Rovers FC"
        },
        "positions": {
            "GK": "Goalkeeper",
            "DF": "Defender",
            "MF": "Midfielder",
            "ST": "Striker"
        },
        "players": {
            "GK": [
                {
                    "team_id": 138,
                    "player_id": 8,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "45.00",
                    "player_first_name": "Asmir",
                    "player_last_name": "Begovic",
                    "short_code": "BOR",
                    "position": "GK",
                    "club_name": "AFC Bournemouth",
                    "club_id": 1,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOR/GK.png"
                },
                {
                    "team_id": 138,
                    "player_id": 36,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "5.00",
                    "player_first_name": "Bernd",
                    "player_last_name": "Leno",
                    "short_code": "ARS",
                    "position": "GK",
                    "club_name": "Arsenal",
                    "club_id": 2,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/ARS/GK.png"
                }
            ],
            "DF": [
                {
                    "team_id": 138,
                    "player_id": 11,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "2.00",
                    "player_first_name": "Charlie",
                    "player_last_name": "Daniels",
                    "short_code": "BOR",
                    "position": "FB",
                    "club_name": "AFC Bournemouth",
                    "club_id": 1,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOR/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 14,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "1.00",
                    "player_first_name": "Simon",
                    "player_last_name": "Francis",
                    "short_code": "BOR",
                    "position": "FB",
                    "club_name": "AFC Bournemouth",
                    "club_id": 1,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOR/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 135,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Souleymane",
                    "player_last_name": "Bamba",
                    "short_code": "CAR",
                    "position": "CB",
                    "club_name": "Cardiff City",
                    "club_id": 5,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CAR/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 246,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Phil",
                    "player_last_name": "Jagielka",
                    "short_code": "EVE",
                    "position": "CB",
                    "club_name": "Everton",
                    "club_id": 8,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/EVE/player.png"
                }
            ],
            "MF": [
                {
                    "team_id": 138,
                    "player_id": 33,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "1.00",
                    "player_first_name": "Henrikh",
                    "player_last_name": "Mkhitaryan",
                    "short_code": "ARS",
                    "position": "MF",
                    "club_name": "Arsenal",
                    "club_id": 2,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/ARS/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 69,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Yves",
                    "player_last_name": "Bissouma",
                    "short_code": "BRI",
                    "position": "MF",
                    "club_name": "Brighton & Hove Albion",
                    "club_id": 3,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BRI/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 117,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Robbie",
                    "player_last_name": "Brady",
                    "short_code": "BUR",
                    "position": "MF",
                    "club_name": "Burnley",
                    "club_id": 4,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BUR/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 272,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Kieran",
                    "player_last_name": "Dowell",
                    "short_code": "EVE",
                    "position": "MF",
                    "club_name": "Everton",
                    "club_id": 8,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/EVE/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 287,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Andre",
                    "player_last_name": "Schurrle",
                    "short_code": "FUL",
                    "position": "MF",
                    "club_name": "Fulham",
                    "club_id": 9,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/FUL/player.png"
                }
            ],
            "ST": [
                {
                    "team_id": 138,
                    "player_id": 76,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Glenn",
                    "player_last_name": "Murray",
                    "short_code": "BRI",
                    "position": "ST",
                    "club_name": "Brighton & Hove Albion",
                    "club_id": 3,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BRI/player.png"
                },
                {
                    "team_id": 138,
                    "player_id": 161,
                    "team_name": "Ben 1's Team",
                    "transfer_value": "3.00",
                    "player_first_name": "Danny",
                    "player_last_name": "Ward",
                    "short_code": "CAR",
                    "position": "ST",
                    "club_name": "Cardiff City",
                    "club_id": 5,
                    "total_points": null,
                    "nextFixture": "",
                    "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CAR/player.png"
                }
            ]
        }
    }
}
```
