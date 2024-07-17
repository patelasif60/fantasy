# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Bids

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{divisionId}/sealed/bids/{teamId}/data/bids`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`round`|Integer||`1` Round id |
|`status`|String||`W`  W for Win,L for Loss and P for Pending |
|`team`|Integer||`1` Team Id|
|`position`|String||`GK` Player position |

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "10.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Adrian",
            "playerLastName": "NULL",
            "playerId": 597,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "West Ham United",
            "playerClubId": 19,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Alex",
            "playerLastName": "Smithies",
            "playerId": 140,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Cardiff City",
            "playerClubId": 5,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "3.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Alex",
            "playerLastName": "McCarthy",
            "playerId": 528,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Southampton",
            "playerClubId": 16,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "4.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Alisson",
            "playerLastName": "Becker",
            "playerId": 376,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Liverpool",
            "playerClubId": 12,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "5.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Anders",
            "playerLastName": "Lindegaard",
            "playerId": 121,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Burnley",
            "playerClubId": 4,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "6.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Angus",
            "playerLastName": "Gunn",
            "playerId": 505,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Southampton",
            "playerClubId": 16,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "7.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Artur",
            "playerLastName": "Boruc",
            "playerId": 30,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "AFC Bournemouth",
            "playerClubId": 1,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "5.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Asmir",
            "playerLastName": "Begovic",
            "playerId": 8,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "AFC Bournemouth",
            "playerClubId": 1,
            "roundNumber": "1",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "5.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Andrew",
            "playerLastName": "Robertson",
            "playerId": 398,
            "playerPosition": "Full-back (FB)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Liverpool",
            "playerClubId": 12,
            "roundNumber": "1",
            "playerPositionShort": "FB"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "3.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Aaron",
            "playerLastName": "Wan-Bissaka",
            "playerId": 233,
            "playerPosition": "Full-back (FB)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Crystal Palace",
            "playerClubId": 7,
            "roundNumber": "1",
            "playerPositionShort": "FB"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "3.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Federico",
            "playerLastName": "Fernandez",
            "playerId": 501,
            "playerPosition": "Centre-back (CB)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Newcastle United",
            "playerClubId": 15,
            "roundNumber": "1",
            "playerPositionShort": "CB"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Achraf",
            "playerLastName": "Lazaar",
            "playerId": 483,
            "playerPosition": "Centre-back (CB)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Newcastle United",
            "playerClubId": 15,
            "roundNumber": "1",
            "playerPositionShort": "CB"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Adrian",
            "playerLastName": "Mariappa",
            "playerId": 573,
            "playerPosition": "Centre-back (CB)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Watford",
            "playerClubId": 18,
            "roundNumber": "1",
            "playerPositionShort": "CB"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Christian",
            "playerLastName": "Pulisic",
            "playerId": 184,
            "playerPosition": "Midfielder (MF)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Chelsea",
            "playerClubId": 6,
            "roundNumber": "1",
            "playerPositionShort": "MF"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "4.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Angel",
            "playerLastName": "Gomes",
            "playerId": 451,
            "playerPosition": "Midfielder (MF)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Manchester United",
            "playerClubId": 14,
            "roundNumber": "1",
            "playerPositionShort": "MF"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Alireza",
            "playerLastName": "Jahanbakhsh",
            "playerId": 91,
            "playerPosition": "Midfielder (MF)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Brighton & Hove Albion",
            "playerClubId": 3,
            "roundNumber": "1",
            "playerPositionShort": "MF"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Ante",
            "playerLastName": "Palaversa",
            "playerId": 403,
            "playerPosition": "Midfielder (MF)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Manchester City",
            "playerClubId": 13,
            "roundNumber": "1",
            "playerPositionShort": "MF"
        },
        {
            "TeamName": "Matt's Team",
            "sealedBidAmount": "2.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Glenn",
            "playerLastName": "Murray",
            "playerId": 76,
            "playerPosition": "Striker (ST)",
            "managerFirstName": "Matt",
            "managerLastName": "Sims",
            "playerClubName": "Brighton & Hove Albion",
            "playerClubId": 3,
            "roundNumber": "1",
            "playerPositionShort": "ST"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "10.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Joe",
            "playerLastName": "Hart",
            "playerId": 123,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Burnley",
            "playerClubId": 4,
            "roundNumber": "2",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "6.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Ben",
            "playerLastName": "Gibson",
            "playerId": 116,
            "playerPosition": "Centre-back (CB)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Burnley",
            "playerClubId": 4,
            "roundNumber": "2",
            "playerPositionShort": "CB"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "10.00",
            "sealedBidStatus": "L",
            "playerFirstName": "Aaron",
            "playerLastName": "Lennon",
            "playerId": 134,
            "playerPosition": "Midfielder (MF)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Burnley",
            "playerClubId": 4,
            "roundNumber": "2",
            "playerPositionShort": "MF"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "4.00",
            "sealedBidStatus": "L",
            "playerFirstName": "Chris",
            "playerLastName": "Wood",
            "playerId": 132,
            "playerPosition": "Striker (ST)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Burnley",
            "playerClubId": 4,
            "roundNumber": "2",
            "playerPositionShort": "ST"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "3.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Ainsley",
            "playerLastName": "Maitland-Niles",
            "playerId": 65,
            "playerPosition": "Full-back (FB)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Arsenal",
            "playerClubId": 2,
            "roundNumber": "2",
            "playerPositionShort": "FB"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "5.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Kamil",
            "playerLastName": "Grabara",
            "playerId": 391,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Liverpool",
            "playerClubId": 12,
            "roundNumber": "2",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "4.00",
            "sealedBidStatus": "W",
            "playerFirstName": "Claudio",
            "playerLastName": "Bravo",
            "playerId": 404,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Manchester City",
            "playerClubId": 13,
            "roundNumber": "2",
            "playerPositionShort": "GK"
        },
        {
            "TeamName": "Johan's Team",
            "sealedBidAmount": "15.00",
            "sealedBidStatus": null,
            "playerFirstName": "Damian Emiliano",
            "playerLastName": "Martinez",
            "playerId": 40,
            "playerPosition": "Goalkeeper (GK)",
            "managerFirstName": "Johan",
            "managerLastName": "Haynes",
            "playerClubName": "Arsenal",
            "playerClubId": 2,
            "roundNumber": "3",
            "playerPositionShort": "GK"
        }
    ]
}
```
