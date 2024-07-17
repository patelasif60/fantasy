# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name="get_month_teams"></a>
## Get list of Month Top Teams

This API will fectch month top teams based on there ranking points. There will also be pagination required for this API.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/month/standings`|`Bearer Token`|


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
|`startDt`|Date|`required`|Ex:`2019-12-01`|
|`endDt`|Date|`required`|Ex:`2019-12-31`|


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
                "total": "58",
                "league_size": "8",
                "squad_size": "15",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "5168.80",
                "position": "1"
            },
            {
                "id": "5052",
                "name": "Scooby Rovers",
                "first_name": "Michael",
                "last_name": "Smith",
                "total": "58",
                "league_size": "5",
                "squad_size": "16",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "4887.50",
                "position": "2"
            },
            {
                "id": "1750",
                "name": "Fox&#039;s Failures",
                "first_name": "Nick",
                "last_name": "Fox",
                "total": "54",
                "league_size": "7",
                "squad_size": "15",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "4609.60",
                "position": "3"
            },
            {
                "id": "1375",
                "name": "Dynamo Deejay",
                "first_name": "Doug",
                "last_name": "Jones",
                "total": "56",
                "league_size": "10",
                "squad_size": "15",
                "transfers": "4",
                "weekend_changes": "1",
                "ranking_points": "4576.00",
                "position": "4"
            },
            {
                "id": "7161",
                "name": "United We Stand",
                "first_name": "Dave",
                "last_name": "Cole",
                "total": "49",
                "league_size": "16",
                "squad_size": "14",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "4567.59",
                "position": "5"
            },
            {
                "id": "3956",
                "name": "Mmmmm, yes, yes!",
                "first_name": "Duncan",
                "last_name": "Cocker",
                "total": "57",
                "league_size": "6",
                "squad_size": "15",
                "transfers": "3",
                "weekend_changes": "1",
                "ranking_points": "4548.40",
                "position": "6"
            },
            {
                "id": "5644",
                "name": "Hakuna Juan Mata",
                "first_name": "stuart",
                "last_name": "du port",
                "total": "56",
                "league_size": "7",
                "squad_size": "15",
                "transfers": "3",
                "weekend_changes": "1",
                "ranking_points": "4494.40",
                "position": "7"
            },
            {
                "id": "1453",
                "name": "Nothing Toulouse",
                "first_name": "Dragy",
                "last_name": ".",
                "total": "55",
                "league_size": "8",
                "squad_size": "16",
                "transfers": "2",
                "weekend_changes": "1",
                "ranking_points": "4489.69",
                "position": "8"
            },
            {
                "id": "3161",
                "name": "AC Moneyball",
                "first_name": "Emre",
                "last_name": "Tezel",
                "total": "58",
                "league_size": "5",
                "squad_size": "15",
                "transfers": "4",
                "weekend_changes": "1",
                "ranking_points": "4480.00",
                "position": "9"
            },
            {
                "id": "2733",
                "name": "Les Couilles des Chien",
                "first_name": "Malcolm",
                "last_name": "Reid",
                "total": "59",
                "league_size": "10",
                "squad_size": "15",
                "transfers": "8",
                "weekend_changes": "1",
                "ranking_points": "4474.00",
                "position": "10"
            }
        ]
    }
}
```
