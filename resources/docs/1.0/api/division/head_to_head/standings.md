# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Head to head Standings

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/12/info/head_to_head`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

> {success} Success Response

Code `200`

Content

```json
{
    "teams": [
        {
            "teamId": 1614,
            "teamName": "Mina Colada",
            "team_points": 30,
            "plays": 11,
            "wins": 10,
            "draws": 0,
            "loses": 1,
            "points_for": 154,
            "points_against": 89,
            "points_diff": 65,
            "first_name": "Stuart",
            "last_name": "Sims",
            "league_position": 1,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 1615,
            "teamName": "The Be Sharps",
            "team_points": 17,
            "plays": 11,
            "wins": 5,
            "draws": 2,
            "loses": 4,
            "points_for": 84,
            "points_against": 65,
            "points_diff": 19,
            "first_name": "Paul",
            "last_name": "Warner",
            "league_position": 2,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 1616,
            "teamName": "Gentleman's Grealish",
            "team_points": 16,
            "plays": 11,
            "wins": 5,
            "draws": 1,
            "loses": 5,
            "points_for": 123,
            "points_against": 94,
            "points_diff": 29,
            "first_name": "Lloydo",
            "last_name": "",
            "league_position": 3,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 4047,
            "teamName": "Ray Bloody Purchase",
            "team_points": 16,
            "plays": 11,
            "wins": 5,
            "draws": 1,
            "loses": 5,
            "points_for": 99,
            "points_against": 115,
            "points_diff": -16,
            "first_name": "Maff",
            "last_name": "Nesbitt",
            "league_position": 4,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 1617,
            "teamName": "The Moura, The Merrier",
            "team_points": 15,
            "plays": 11,
            "wins": 4,
            "draws": 3,
            "loses": 4,
            "points_for": 118,
            "points_against": 98,
            "points_diff": 20,
            "first_name": "Matt",
            "last_name": "Sims",
            "league_position": 5,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 1612,
            "teamName": "On the Head Son.",
            "team_points": 15,
            "plays": 10,
            "wins": 5,
            "draws": 0,
            "loses": 5,
            "points_for": 86,
            "points_against": 78,
            "points_diff": 8,
            "first_name": "Karl",
            "last_name": "Wyatt",
            "league_position": 6,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 3763,
            "teamName": "Ibe Made A Huge Mistake",
            "team_points": 15,
            "plays": 11,
            "wins": 5,
            "draws": 0,
            "loses": 6,
            "points_for": 76,
            "points_against": 89,
            "points_diff": -13,
            "first_name": "Joe",
            "last_name": "Towey",
            "league_position": 7,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 5870,
            "teamName": "When Harry met Shaqiri",
            "team_points": 15,
            "plays": 11,
            "wins": 5,
            "draws": 0,
            "loses": 6,
            "points_for": 83,
            "points_against": 98,
            "points_diff": -15,
            "first_name": "John",
            "last_name": "Bloomfield",
            "league_position": 8,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 1613,
            "teamName": "Où est Pepe",
            "team_points": 15,
            "plays": 11,
            "wins": 5,
            "draws": 0,
            "loses": 6,
            "points_for": 93,
            "points_against": 133,
            "points_diff": -40,
            "first_name": "Shady",
            "last_name": "",
            "league_position": 9,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 1611,
            "teamName": "Adams Family Values",
            "team_points": 11,
            "plays": 11,
            "wins": 3,
            "draws": 2,
            "loses": 6,
            "points_for": 81,
            "points_against": 100,
            "points_diff": -19,
            "first_name": "James",
            "last_name": "Lovell",
            "league_position": 10,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        },
        {
            "teamId": 9709,
            "teamName": "Harvey's Team",
            "team_points": 10,
            "plays": 11,
            "wins": 3,
            "draws": 1,
            "loses": 7,
            "points_for": 78,
            "points_against": 116,
            "points_diff": -38,
            "first_name": "Harvey",
            "last_name": "Pringle",
            "league_position": 11,
            "crest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png"
        }
    ],
    "gameweeks": [
        {
            "id": 55,
            "number": "14",
            "is_valid_cup_round": true,
            "start": "2019-11-05T00:00:00.000000Z",
            "end": "2019-11-12T00:00:00.000000Z"
        },
        {
            "id": 57,
            "number": "16",
            "is_valid_cup_round": true,
            "start": "2019-11-19T00:00:00.000000Z",
            "end": "2019-11-26T00:00:00.000000Z"
        },
        {
            "id": 58,
            "number": "17",
            "is_valid_cup_round": true,
            "start": "2019-11-26T00:00:00.000000Z",
            "end": "2019-12-03T00:00:00.000000Z"
        },
        {
            "id": 59,
            "number": "18",
            "is_valid_cup_round": true,
            "start": "2019-12-03T00:00:00.000000Z",
            "end": "2019-12-10T00:00:00.000000Z"
        },
        {
            "id": 60,
            "number": "19",
            "is_valid_cup_round": true,
            "start": "2019-12-10T00:00:00.000000Z",
            "end": "2019-12-17T00:00:00.000000Z"
        },
        {
            "id": 61,
            "number": "20",
            "is_valid_cup_round": true,
            "start": "2019-12-17T00:00:00.000000Z",
            "end": "2019-12-24T00:00:00.000000Z"
        },
        {
            "id": 62,
            "number": "21",
            "is_valid_cup_round": true,
            "start": "2019-12-24T00:00:00.000000Z",
            "end": "2019-12-31T00:00:00.000000Z"
        },
        {
            "id": 63,
            "number": "22",
            "is_valid_cup_round": true,
            "start": "2019-12-31T00:00:00.000000Z",
            "end": "2020-01-07T00:00:00.000000Z"
        },
        {
            "id": 64,
            "number": "23",
            "is_valid_cup_round": true,
            "start": "2020-01-07T00:00:00.000000Z",
            "end": "2020-01-14T00:00:00.000000Z"
        },
        {
            "id": 65,
            "number": "24",
            "is_valid_cup_round": true,
            "start": "2020-01-14T00:00:00.000000Z",
            "end": "2020-01-21T00:00:00.000000Z"
        },
        {
            "id": 66,
            "number": "25",
            "is_valid_cup_round": true,
            "start": "2020-01-21T00:00:00.000000Z",
            "end": "2020-01-28T00:00:00.000000Z"
        },
        {
            "id": 67,
            "number": "26",
            "is_valid_cup_round": true,
            "start": "2020-01-28T00:00:00.000000Z",
            "end": "2020-02-04T00:00:00.000000Z"
        },
        {
            "id": 68,
            "number": "27",
            "is_valid_cup_round": true,
            "start": "2020-02-04T00:00:00.000000Z",
            "end": "2020-02-18T00:00:00.000000Z"
        },
        {
            "id": 70,
            "number": "29",
            "is_valid_cup_round": true,
            "start": "2020-02-18T00:00:00.000000Z",
            "end": "2020-02-25T00:00:00.000000Z"
        },
        {
            "id": 72,
            "number": "31",
            "is_valid_cup_round": true,
            "start": "2020-03-03T00:00:00.000000Z",
            "end": "2020-03-10T00:00:00.000000Z"
        },
        {
            "id": 73,
            "number": "32",
            "is_valid_cup_round": true,
            "start": "2020-03-10T00:00:00.000000Z",
            "end": "2020-03-17T00:00:00.000000Z"
        },
        {
            "id": 76,
            "number": "35",
            "is_valid_cup_round": true,
            "start": "2020-03-31T00:00:00.000000Z",
            "end": "2020-04-07T00:00:00.000000Z"
        },
        {
            "id": 77,
            "number": "36",
            "is_valid_cup_round": true,
            "start": "2020-04-07T00:00:00.000000Z",
            "end": "2020-04-14T00:00:00.000000Z"
        },
        {
            "id": 79,
            "number": "38",
            "is_valid_cup_round": true,
            "start": "2020-04-21T00:00:00.000000Z",
            "end": "2020-04-28T00:00:00.000000Z"
        },
        {
            "id": 80,
            "number": "39",
            "is_valid_cup_round": true,
            "start": "2020-04-28T00:00:00.000000Z",
            "end": "2020-05-05T00:00:00.000000Z"
        },
        {
            "id": 81,
            "number": "40",
            "is_valid_cup_round": true,
            "start": "2020-05-05T00:00:00.000000Z",
            "end": "2020-05-12T00:00:00.000000Z"
        },
        {
            "id": 82,
            "number": "41",
            "is_valid_cup_round": true,
            "start": "2020-05-12T00:00:00.000000Z",
            "end": "2020-05-19T00:00:00.000000Z"
        }
    ]
}
```
