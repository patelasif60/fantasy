# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Head to head Matches

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GEt|`/api/leagues/12/info/head_to_head/filter`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

For filter of id you have to pass this gameweek id get from gameweek array `"id": 30`

|Params|Type|Values|Example|
|:-|:-|:-|
|`id`|Integer|`required`|`30`|

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "homeTeam": "Mina Colada",
            "awayTeam": "When Harry met Shaqiri",
            "homeTeamId": 1614,
            "awayTeamId": 5870,
            "homePoints": 14,
            "awayPoints": 5,
            "homeFirstName": "Stuart",
            "homeLastName": "Sims",
            "awayFirstName": "John",
            "awayLastName": "Bloomfield",
            "start": "2019-11-05",
            "end": "2019-11-12",
            "homeCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "awayCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "gameweek": "05/11/19 to 12/11/19"
        },
        {
            "homeTeam": "Où est Pepe",
            "awayTeam": "Ray Bloody Purchase",
            "homeTeamId": 1613,
            "awayTeamId": 4047,
            "homePoints": 2,
            "awayPoints": 7,
            "homeFirstName": "Shady",
            "homeLastName": "",
            "awayFirstName": "Maff",
            "awayLastName": "Nesbitt",
            "start": "2019-11-05",
            "end": "2019-11-12",
            "homeCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "awayCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "gameweek": "05/11/19 to 12/11/19"
        },
        {
            "homeTeam": "The Be Sharps",
            "awayTeam": "Harvey's Team",
            "homeTeamId": 1615,
            "awayTeamId": 9709,
            "homePoints": 16,
            "awayPoints": 5,
            "homeFirstName": "Paul",
            "homeLastName": "Warner",
            "awayFirstName": "Harvey",
            "awayLastName": "Pringle",
            "start": "2019-11-05",
            "end": "2019-11-12",
            "homeCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "awayCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "gameweek": "05/11/19 to 12/11/19"
        },
        {
            "homeTeam": "Adams Family Values",
            "awayTeam": "Gentleman's Grealish",
            "homeTeamId": 1611,
            "awayTeamId": 1616,
            "homePoints": 1,
            "awayPoints": 5,
            "homeFirstName": "James",
            "homeLastName": "Lovell",
            "awayFirstName": "Lloydo",
            "awayLastName": "",
            "start": "2019-11-05",
            "end": "2019-11-12",
            "homeCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "awayCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "gameweek": "05/11/19 to 12/11/19"
        },
        {
            "homeTeam": "On the Head Son.",
            "awayTeam": "The Moura, The Merrier",
            "homeTeamId": 1612,
            "awayTeamId": 1617,
            "homePoints": 8,
            "awayPoints": 4,
            "homeFirstName": "Karl",
            "homeLastName": "Wyatt",
            "awayFirstName": "Matt",
            "awayLastName": "Sims",
            "start": "2019-11-05",
            "end": "2019-11-12",
            "homeCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "awayCrest": "http://ashish-fantasyleague.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
            "gameweek": "05/11/19 to 12/11/19"
        }
    ]
}
```
