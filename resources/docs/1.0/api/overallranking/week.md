# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name="get_week_teams"></a>
## Get list of Week Top Teams

This API will fectch week top teams based on there ranking points. There will also be pagination required for this API.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/week/standings`|`Bearer Token`|


### URL Params

|Params|Type|Values|Example|
|:-|:-|:-|
|`division`|Integer|`required`|Ex:`1`|


### Data Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|Notes|
|:-|:-|:-|
|`package`|Integer|`optional`|Ex:`1`|
|`start`|Integer|`required`|Ex:`0,100,200`|`This is pagination offset of next record`|
|`length`|Integer|`required`|Ex:`100`|`Num of records require`|
|`startDt`|Date|`required`|Ex:`2019-12-03`|
|`endDt`|Date|`required`|Ex:`2019-12-10`|


> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "start": "0",
        "length": "10",
        "recordsTotal": 6541,
        "data": [
            {
                "id": "3407",
                "name": "Murphy’s Law",
                "first_name": "Wai",
                "last_name": "Cheung",
                "total": "49",
                "league_size": "8",
                "squad_size": "15",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "4256.40",
                "position": "1"
            },
            {
                "id": "1453",
                "name": "Nothing Toulouse",
                "first_name": "Dragy",
                "last_name": ".",
                "total": "51",
                "league_size": "8",
                "squad_size": "16",
                "transfers": "2",
                "weekend_changes": "1",
                "ranking_points": "4200.44",
                "position": "2"
            },
            {
                "id": "1754",
                "name": "When Harry met Alli",
                "first_name": "Lee",
                "last_name": "Shorter",
                "total": "50",
                "league_size": "5",
                "squad_size": "16",
                "transfers": "1",
                "weekend_changes": "1",
                "ranking_points": "4018.75",
                "position": "3"
            },
            {
                "id": "1285",
                "name": "Eddy&#039;s Eagles ",
                "first_name": "Eddy",
                "last_name": "Darragh",
                "total": "47",
                "league_size": "8",
                "squad_size": "15",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "4009.20",
                "position": "4"
            },
            {
                "id": "2480",
                "name": "Ings Can Only Get Better",
                "first_name": "Tom",
                "last_name": "Street",
                "total": "45",
                "league_size": "11",
                "squad_size": "16",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "3864.37",
                "position": "5"
            },
            {
                "id": "5644",
                "name": "Hakuna Juan Mata",
                "first_name": "stuart",
                "last_name": "du port",
                "total": "49",
                "league_size": "7",
                "squad_size": "15",
                "transfers": "3",
                "weekend_changes": "1",
                "ranking_points": "3837.60",
                "position": "6"
            },
            {
                "id": "7161",
                "name": "United We Stand",
                "first_name": "Dave",
                "last_name": "Cole",
                "total": "42",
                "league_size": "16",
                "squad_size": "14",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "3829.37",
                "position": "7"
            },
            {
                "id": "4907",
                "name": "Spotspurs",
                "first_name": "Philip",
                "last_name": "Bear",
                "total": "43",
                "league_size": "13",
                "squad_size": "15",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "3772.80",
                "position": "8"
            },
            {
                "id": "2582",
                "name": "Azzurri Blues",
                "first_name": "richard",
                "last_name": "strudwick",
                "total": "48",
                "league_size": "9",
                "squad_size": "16",
                "transfers": "3",
                "weekend_changes": "1",
                "ranking_points": "3771.75",
                "position": "9"
            },
            {
                "id": "5721",
                "name": "Tim Sherwood&#039;s Gilet",
                "first_name": "Byron",
                "last_name": "Cornish",
                "total": "46",
                "league_size": "7",
                "squad_size": "16",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "3771.75",
                "position": "9"
            }
        ]
    }
}
```
