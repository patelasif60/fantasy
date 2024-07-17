# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Team details

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/transfers/sealed/bids/teams/{team}`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

> {success} Success Response

Code `200`

Content

```json
{
    "teamPlayers": {
        "GK": [
            {
                "team_id": 2435,
                "player_id": 272,
                "team_name": "Kolobos PFC",
                "player_first_name": "Jordan",
                "player_last_name": "Pickford",
                "short_code": "EVE",
                "position": "GK",
                "club_name": "Everton",
                "club_id": 8,
                "transfer_value": "8.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/EVE/GK.png"
            }
        ],
        "FB": [
            {
                "team_id": 2435,
                "player_id": 58,
                "team_name": "Kolobos PFC",
                "player_first_name": "Nacho",
                "player_last_name": "Monreal",
                "short_code": "ARS",
                "position": "FB",
                "club_name": "Arsenal",
                "club_id": 2,
                "transfer_value": "0.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/ARS/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 220,
                "team_name": "Kolobos PFC",
                "player_first_name": "Patrick",
                "player_last_name": "van Aanholt",
                "short_code": "CP",
                "position": "FB",
                "club_name": "Crystal Palace",
                "club_id": 7,
                "transfer_value": "4.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CP/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 699,
                "team_name": "Kolobos PFC",
                "player_first_name": "Erik",
                "player_last_name": "Pieters",
                "short_code": "BUR",
                "position": "FB",
                "club_name": "Burnley",
                "club_id": 4,
                "transfer_value": "0.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BUR/player.png"
            }
        ],
        "CB": [
            {
                "team_id": 2435,
                "player_id": 490,
                "team_name": "Kolobos PFC",
                "player_first_name": "Jamaal",
                "player_last_name": "Lascelles",
                "short_code": "NEW",
                "position": "CB",
                "club_name": "Newcastle United",
                "club_id": 15,
                "transfer_value": "0.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/NEW/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 649,
                "team_name": "Kolobos PFC",
                "player_first_name": "Ryan",
                "player_last_name": "Bennett",
                "short_code": "WOL",
                "position": "CB",
                "club_name": "Wolverhampton Wanderers",
                "club_id": 20,
                "transfer_value": "3.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/WOL/player.png"
            }
        ],
        "MF": [
            {
                "team_id": 2435,
                "player_id": 367,
                "team_name": "Kolobos PFC",
                "player_first_name": "Youri",
                "player_last_name": "Tielemans",
                "short_code": "LEI",
                "position": "MF",
                "club_name": "Leicester City",
                "club_id": 11,
                "transfer_value": "13.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/LEI/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 380,
                "team_name": "Kolobos PFC",
                "player_first_name": "Mohamed",
                "player_last_name": "Salah",
                "short_code": "LIV",
                "position": "MF",
                "club_name": "Liverpool",
                "club_id": 12,
                "transfer_value": "25.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/LIV/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 553,
                "team_name": "Kolobos PFC",
                "player_first_name": "Erik",
                "player_last_name": "Lamela",
                "short_code": "TOT",
                "position": "MF",
                "club_name": "Tottenham Hotspur",
                "club_id": 17,
                "transfer_value": "1.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/TOT/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 211,
                "team_name": "Kolobos PFC",
                "player_first_name": "Luka",
                "player_last_name": "Milivojevic",
                "short_code": "CP",
                "position": "MF",
                "club_name": "Crystal Palace",
                "club_id": 7,
                "transfer_value": "5.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CP/player.png"
            }
        ],
        "ST": [
            {
                "team_id": 2435,
                "player_id": 132,
                "team_name": "Kolobos PFC",
                "player_first_name": "Ashley",
                "player_last_name": "Barnes",
                "short_code": "BUR",
                "position": "ST",
                "club_name": "Burnley",
                "club_id": 4,
                "transfer_value": "0.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BUR/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 352,
                "team_name": "Kolobos PFC",
                "player_first_name": "Jamie",
                "player_last_name": "Vardy",
                "short_code": "LEI",
                "position": "ST",
                "club_name": "Leicester City",
                "club_id": 11,
                "transfer_value": "15.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/LEI/player.png"
            },
            {
                "team_id": 2435,
                "player_id": 888,
                "team_name": "Kolobos PFC",
                "player_first_name": "Neal",
                "player_last_name": "Maupay",
                "short_code": "BHA",
                "position": "ST",
                "club_name": "Brighton & Hove Albion",
                "club_id": 3,
                "transfer_value": "8.00",
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BHA/player.png"
            }
        ]
    },
    "team": {
        "id": 2435,
        "name": "Kolobos PFC",
        "manager_id": 6,
        "crest_id": null,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "121623c5-ab14-46f1-9b63-ebb34cba3fe1",
        "team_budget": "162.00",
        "is_legacy": 1,
        "season_quota_used": 4,
        "monthly_quota_used": 1,
        "created_at": "2019-07-09 13:33:56",
        "updated_at": "2020-01-14 15:43:14",
        "crest": "https://fantasyleague-prod.s3.amazonaws.com/1024/conversions/FL_Team-Badge-Icons_AW-04-thumb.png",
        "defaultSquadSize": 13,
        "budget": "162.00"
    },
    "positions": {
        "GK": "Goalkeeper",
        "FB": "Fullback",
        "CB": "Centreback",
        "MF": "Midfielder",
        "ST": "Striker"
    },
    "clubs": {
        "2": "Arsenal",
        "48": "Aston Villa",
        "3": "Brighton & Hove Albion",
        "1": "AFC Bournemouth",
        "4": "Burnley",
        "6": "Chelsea",
        "7": "Crystal Palace",
        "8": "Everton",
        "11": "Leicester City",
        "12": "Liverpool",
        "13": "Manchester City",
        "14": "Manchester United",
        "15": "Newcastle United",
        "49": "Norwich City",
        "16": "Southampton",
        "50": "Sheffield United",
        "17": "Tottenham Hotspur",
        "18": "Watford",
        "19": "West Ham United",
        "20": "Wolverhampton Wanderers"
    },
    "teams": {
        "1661": "Who's Who of Poo.",
        "2431": "Turdagain FFS",
        "2432": "Accrington Sonley",
        "2433": "Planck's Constants",
        "2434": "My Little Pony",
        "2435": "Kolobos PFC",
        "2437": "The Lego Knights",
        "3037": "Millermen",
        "3321": "Juvetude FC",
        "3974": "Frankie and Connor Rangers",
        "3991": "Bentleys XI",
        "4629": "V.A.R my Lord FC",
        "5686": "Josies Jesters",
        "5837": "Huntsea FC",
        "6979": "Slugger’s back",
        "9097": "Gareth Bale's Hotscotts",
        "9506": "Mandem Utd",
        "9519": "Swabinho Returning FC"
    },
    "isGk": "GK",
    "selectedPlayers": [
        {
            "id": 42602,
            "transfer_rounds_id": 4500,
            "team_id": 2435,
            "player_in": 500,
            "player_out": 553,
            "amount": "0.00",
            "status": null,
            "manually_process_status": "pending",
            "is_process": false,
            "created_at": "2020-01-28 08:29:34",
            "updated_at": "2020-01-28 08:29:34",
            "player_first_name": "Ciaran",
            "player_last_name": "Clark",
            "player_id": 500,
            "position": "Centre-back (CB)",
            "short_code": "NEW",
            "club_name": "Newcastle United",
            "club_id": 15,
            "club_id_out": 17,
            "transfer_value": "1.00",
            "position_short": "CB"
        },
        {
            "id": 42603,
            "transfer_rounds_id": 4500,
            "team_id": 2435,
            "player_in": 224,
            "player_out": 220,
            "amount": "0.00",
            "status": null,
            "manually_process_status": "pending",
            "is_process": false,
            "created_at": "2020-01-28 08:29:34",
            "updated_at": "2020-01-28 08:29:34",
            "player_first_name": "Vicente",
            "player_last_name": "Guaita",
            "player_id": 224,
            "position": "Goalkeeper (GK)",
            "short_code": "CP",
            "club_name": "Crystal Palace",
            "club_id": 7,
            "club_id_out": 7,
            "transfer_value": "4.00",
            "position_short": "GK"
        },
        {
            "id": 42604,
            "transfer_rounds_id": 4500,
            "team_id": 2435,
            "player_in": 247,
            "player_out": 352,
            "amount": "0.00",
            "status": null,
            "manually_process_status": "pending",
            "is_process": false,
            "created_at": "2020-01-28 08:30:20",
            "updated_at": "2020-01-28 08:30:20",
            "player_first_name": "Cenk",
            "player_last_name": "Tosun",
            "player_id": 247,
            "position": "Striker (ST)",
            "short_code": "CP",
            "club_name": "Crystal Palace",
            "club_id": 7,
            "club_id_out": 11,
            "transfer_value": "15.00",
            "position_short": "ST"
        },
        {
            "id": 42605,
            "transfer_rounds_id": 4500,
            "team_id": 2435,
            "player_in": 775,
            "player_out": 380,
            "amount": "0.00",
            "status": null,
            "manually_process_status": "pending",
            "is_process": false,
            "created_at": "2020-01-28 08:30:20",
            "updated_at": "2020-01-28 08:30:20",
            "player_first_name": "John",
            "player_last_name": "Fleck",
            "player_id": 775,
            "position": "Defensive Midfielder (DMF)",
            "short_code": "SU",
            "club_name": "Sheffield United",
            "club_id": 50,
            "club_id_out": 12,
            "transfer_value": "25.00",
            "position_short": "MF"
        }
    ],
    "bidIncrementDecimalPlace": 2,
    "playerInitialCount": {
        "Barnes": 10,
        "Bennett": 20,
        "Clark": 12,
        "Fleck": 1,
        "Guaita": 1,
        "Lamela": 1,
        "Lascelles": 1,
        "Maupay": 1,
        "Milivojevic": 1,
        "Monreal": 1,
        "Pickford": 1,
        "Pieters": 1,
        "Salah": 1,
        "Tielemans": 1,
        "Tosun": 1,
        "van Aanholt": 1,
        "Vardy": 1
    },
    "isRoundProcessed": 0,
    "round": {
        "id": 4500,
        "division_id": 930,
        "start": "2020-01-22 14:50:00",
        "end": "2020-01-23 12:00:00",
        "is_process": "U",
        "number": 10,
        "created_at": "2020-01-27 07:24:19",
        "updated_at": "2020-01-27 07:24:19"
    },
    "maxClubPlayers": 2,
    "playersData": [
        {
            "id": 42602,
            "club_id": 15,
            "club_id_out": 17,
            "oldPlayerId": 553,
            "newPlayerId": 500,
            "oldPlayerAmount": "1.00",
            "newPlayerAmount": "0.00"
        },
        {
            "id": 42603,
            "club_id": 7,
            "club_id_out": 7,
            "oldPlayerId": 220,
            "newPlayerId": 224,
            "oldPlayerAmount": "4.00",
            "newPlayerAmount": "0.00"
        },
        {
            "id": 42604,
            "club_id": 7,
            "club_id_out": 11,
            "oldPlayerId": 352,
            "newPlayerId": 247,
            "oldPlayerAmount": "15.00",
            "newPlayerAmount": "0.00"
        },
        {
            "id": 42605,
            "club_id": 50,
            "club_id_out": 12,
            "oldPlayerId": 380,
            "newPlayerId": 775,
            "oldPlayerAmount": "25.00",
            "newPlayerAmount": "0.00"
        }
    ],
    "assetUrl": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend",
    "messages": {
        "select_player": "Please select a player you want to transfer",
        "formation": "Formation problem: no valid formation is possible with your selection",
        "club_quota": "Club quota is full",
        "max_bid_per_round": "You have already reached the maximum number of bids per round.",
        "monthly_quota_used": "You are not permitted to make any more bids as you will exceed the monthly transfer quota.",
        "season_quota_used": "You are not permitted to make any more bids as you will exceed the season transfer quota.",
        "budget": "Team budget is not enough",
        "bid_increment": "Your increment bid not match our criteria",
        "bid_minimum": "Your minimum bid not match our criteria",
        "squad_size": "Default squad size error",
        "transfer_process": "Please wait we are processing your bids.",
        "supersub_reset": "Please note that Supersubs will be cleared if you are successful with any of your bids",
        "duplicate_player": "Something was wrong!"
    },
    "teamClubsPlayer": {
        "2": 1,
        "3": 1,
        "4": 2,
        "7": 2,
        "8": 1,
        "11": 1,
        "12": 0,
        "15": 2,
        "17": 0,
        "20": 1,
        "50": 1
    },
    "moneyBackEnum": {
        "NONE": "none",
        "HUNDERED_PERCENT": "hunderedPercent",
        "FIFTY_PERCENT": "fiftyPercent",
        "CHAIRMAN_CAN_EDIT_BOUGHT_AND_SOLDPRICE": "chairmaneditboughtsoldprice"
    },
    "mergeDefenders": "No",
    "defensiveMidfields": "No",
    "moneyBack": "hunderedPercent",
    "sealBidIncrement": "0.50",
    "sealBidMinimum": "0.00",
    "maxSealBidsPerTeamPerRound": 5,
    "seasonFreeAgentTransferLimit": 1000,
    "monthlyFreeAgentTransferLimit": 100
}
```
