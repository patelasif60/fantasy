# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Team details

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{divisionId}/sealed/bids/teams/{teamId}/details`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

> {success} Success Response

Code `200`

Content

```json
{
    "team": {
        "id": 166,
        "name": "Matt's Team",
        "manager_id": 37,
        "crest_id": 3,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "9bfe3d95-992e-467a-9a4f-9d8d3991957e",
        "team_budget": "126.00",
        "created_at": "2019-05-07 10:56:38",
        "updated_at": "2019-05-09 04:52:42",
        "crest": "https://fantasyleague-qa.s3.amazonaws.com/3/conversions/21f2b1f541739d592e19cdcd5e56ebbb-thumb.jpg",
        "defaultSquadSize": 15,
        "squadSize": 15,
        "budget": 126
    },
    "teamPlayers": {
        "GK": [
            {
                "team_id": 166,
                "player_id": 121,
                "team_name": "Matt's Team",
                "player_first_name": "Anders",
                "player_last_name": "Lindegaard",
                "short_code": "BUR",
                "position": "GK",
                "club_name": "Burnley",
                "club_id": 4,
                "transfer_value": "5.00",
                "total_points": null,
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BUR/GK.png"
            },
            {
                "team_id": 166,
                "player_id": 140,
                "team_name": "Matt's Team",
                "player_first_name": "Alex",
                "player_last_name": "Smithies",
                "short_code": "CAR",
                "position": "GK",
                "club_name": "Cardiff City",
                "club_id": 5,
                "transfer_value": "7.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CAR/GK.png"
            },
            {
                "team_id": 166,
                "player_id": 376,
                "team_name": "Matt's Team",
                "player_first_name": "Alisson Ramses",
                "player_last_name": "Becker",
                "short_code": "LIV",
                "position": "GK",
                "club_name": "Liverpool",
                "club_id": 12,
                "transfer_value": "5.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/LIV/GK.png"
            },
            {
                "team_id": 166,
                "player_id": 528,
                "team_name": "Matt's Team",
                "player_first_name": "Alex",
                "player_last_name": "McCarthy",
                "short_code": "SOT",
                "position": "GK",
                "club_name": "Southampton",
                "club_id": 16,
                "transfer_value": "6.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/SOT/GK.png"
            },
            {
                "team_id": 166,
                "player_id": 597,
                "team_name": "Matt's Team",
                "player_first_name": "Adrian",
                "player_last_name": "San Miguel del Castillo",
                "short_code": "WHU",
                "position": "GK",
                "club_name": "West Ham United",
                "club_id": 19,
                "transfer_value": "5.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/WHU/GK.png"
            }
        ],
        "FB": [
            {
                "team_id": 166,
                "player_id": 65,
                "team_name": "Matt's Team",
                "player_first_name": "Ainsley",
                "player_last_name": "Maitland-Niles",
                "short_code": "ARS",
                "position": "FB",
                "club_name": "Arsenal",
                "club_id": 2,
                "transfer_value": "4.00",
                "total_points": "1",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/ARS/player.png"
            },
            {
                "team_id": 166,
                "player_id": 398,
                "team_name": "Matt's Team",
                "player_first_name": "Andrew",
                "player_last_name": "Robertson",
                "short_code": "LIV",
                "position": "FB",
                "club_name": "Liverpool",
                "club_id": 12,
                "transfer_value": "4.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/LIV/player.png"
            }
        ],
        "CB": [
            {
                "team_id": 166,
                "player_id": 90,
                "team_name": "Matt's Team",
                "player_first_name": "Ben",
                "player_last_name": "Barclay",
                "short_code": "BRI",
                "position": "CB",
                "club_name": "Brighton & Hove Albion",
                "club_id": 3,
                "transfer_value": "4.00",
                "total_points": null,
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BRI/player.png"
            },
            {
                "team_id": 166,
                "player_id": 97,
                "team_name": "Matt's Team",
                "player_first_name": "Ben",
                "player_last_name": "White",
                "short_code": "BRI",
                "position": "CB",
                "club_name": "Brighton & Hove Albion",
                "club_id": 3,
                "transfer_value": "4.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BRI/player.png"
            },
            {
                "team_id": 166,
                "player_id": 336,
                "team_name": "Matt's Team",
                "player_first_name": "Demeaco",
                "player_last_name": "Duhaney",
                "short_code": "HUD",
                "position": "CB",
                "club_name": "Huddersfield Town",
                "club_id": 10,
                "transfer_value": "4.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/HUD/player.png"
            }
        ],
        "MF": [
            {
                "team_id": 166,
                "player_id": 50,
                "team_name": "Matt's Team",
                "player_first_name": "Alex",
                "player_last_name": "Iwobi",
                "short_code": "ARS",
                "position": "MF",
                "club_name": "Arsenal",
                "club_id": 2,
                "transfer_value": "4.00",
                "total_points": "3",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/ARS/player.png"
            },
            {
                "team_id": 166,
                "player_id": 451,
                "team_name": "Matt's Team",
                "player_first_name": "Angel",
                "player_last_name": "Gomes",
                "short_code": "MUN",
                "position": "MF",
                "club_name": "Manchester United",
                "club_id": 14,
                "transfer_value": "3.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/MUN/player.png"
            },
            {
                "team_id": 166,
                "player_id": 555,
                "team_name": "Matt's Team",
                "player_first_name": "Christian",
                "player_last_name": "Dannemann Eriksen",
                "short_code": "TOT",
                "position": "MF",
                "club_name": "Tottenham Hotspur",
                "club_id": 17,
                "transfer_value": "4.00",
                "total_points": "4",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/TOT/player.png"
            }
        ],
        "ST": [
            {
                "team_id": 166,
                "player_id": 213,
                "team_name": "Matt's Team",
                "player_first_name": "Alexander",
                "player_last_name": "Sorloth",
                "short_code": "CRY",
                "position": "ST",
                "club_name": "Crystal Palace",
                "club_id": 7,
                "transfer_value": "10.00",
                "total_points": "0",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CRY/player.png"
            },
            {
                "team_id": 166,
                "player_id": 593,
                "team_name": "Matt's Team",
                "player_first_name": "Gerard",
                "player_last_name": "Deulofeu Lazaro",
                "short_code": "WAT",
                "position": "ST",
                "club_name": "Watford",
                "club_id": 18,
                "transfer_value": "5.00",
                "total_points": "6",
                "isSealBid": false,
                "nextFixture": "2019-05-12 14:00:00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/WAT/player.png"
            }
        ]
    },
    "teams": {
        "166": "Matt's Team",
        "167": "Johan's Team",
        "168": "Richard's Team",
        "169": "Ben's Team"
    },
    "round": {
        "id": 6,
        "division_id": 39,
        "start": "2019-05-07T15:29:31.000000Z",
        "end": "2019-05-08T15:29:31.000000Z",
        "number": "3"
    },
    "roundsFilter": [
        {
            "id": 4,
            "division_id": 39,
            "start": "2019-05-05T15:29:31.000000Z",
            "end": "2019-05-06T15:29:31.000000Z",
            "number": "1"
        },
        {
            "id": 5,
            "division_id": 39,
            "start": "2019-05-06T15:29:31.000000Z",
            "end": "2019-05-07T15:29:31.000000Z",
            "number": "2"
        },
        {
            "id": 6,
            "division_id": 39,
            "start": "2019-05-07T15:29:31.000000Z",
            "end": "2019-05-08T15:29:31.000000Z",
            "number": "3"
        }
    ],
    "statusFilter": {
        "W": "Won",
        "L": "Lost",
        "P": "Pending"
    },
    "clubsFilter": {
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
        "20": "Wolverhampton Wanderers"
    },
    "positionsFilter": {
        "GK": "Goalkeeper",
        "FB": "Fullback",
        "CB": "Centreback",
        "MF": "Midfielder",
        "ST": "Striker"
    },
    "teamClubsPlayer": {
        "2": 2,
        "3": 2,
        "4": 1,
        "5": 1,
        "7": 1,
        "10": 1,
        "12": 2,
        "14": 1,
        "16": 1,
        "17": 1,
        "18": 1,
        "19": 1
    },
   "availablePosition": [
        "FB",
        "ST",
        "MF",
        "CB"
    ],
    "mergeDefenders": "No",
    "defensiveMidfields": "No"
}
```
