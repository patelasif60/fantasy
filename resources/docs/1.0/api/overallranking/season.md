# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name="get_seaon_teams"></a>
## Get list of Season Top Teams

This API will fectch season top teams based on there ranking points. There will also be pagination required for this API.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{division}/season/standings`|`Bearer Token`|


### URL Params

|Params|Type|Values|Example|
|:-|:-|:-|
|`division`|Integer|`required`|Ex:`1`|


### Data Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|Notes|
|:-|:-|:-|
|`package`|Integer|`optional`|Ex:`1`|
|`start`|Integer|`required`|Ex:`0,100,200`|`This is pagination offset of next record`
|`length`|Integer|`required`|Ex:`100`|`Num of records require`


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
                "id": "2274",
                "name": "The Shots",
                "first_name": "Pete",
                "last_name": "Dewar",
                "total": "291",
                "league_size": "10",
                "squad_size": "16",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "22684.06",
                "position": "1"
            },
            {
                "id": "6905",
                "name": "Yabootee",
                "first_name": "chris",
                "last_name": "boyle",
                "total": "301",
                "league_size": "8",
                "squad_size": "18",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "21975.94",
                "position": "2"
            },
            {
                "id": "6115",
                "name": "On me Od sonne",
                "first_name": "Arthur",
                "last_name": "OLoan",
                "total": "306",
                "league_size": "7",
                "squad_size": "18",
                "transfers": "11",
                "weekend_changes": "1",
                "ranking_points": "20953.52",
                "position": "3"
            },
            {
                "id": "1554",
                "name": "Ginger Pussies",
                "first_name": "Sir Terence Trent",
                "last_name": "D&#039;Arnold",
                "total": "289",
                "league_size": "8",
                "squad_size": "15",
                "transfers": "12",
                "weekend_changes": "1",
                "ranking_points": "20680.40",
                "position": "4"
            },
            {
                "id": "5052",
                "name": "Scooby Rovers",
                "first_name": "Michael",
                "last_name": "Smith",
                "total": "285",
                "league_size": "5",
                "squad_size": "16",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "20243.75",
                "position": "5"
            },
            {
                "id": "1753",
                "name": "Rooney loves Everton FC Pyjamas",
                "first_name": "Marc",
                "last_name": "Gibson",
                "total": "274",
                "league_size": "7",
                "squad_size": "15",
                "transfers": 0,
                "weekend_changes": "1",
                "ranking_points": "19937.60",
                "position": "6"
            },
            {
                "id": "1755",
                "name": "Transit Of Venus Across The Sun",
                "first_name": "Stuart",
                "last_name": "Fraser",
                "total": "284",
                "league_size": "5",
                "squad_size": "16",
                "transfers": "3",
                "weekend_changes": "1",
                "ranking_points": "19768.75",
                "position": "7"
            },
            {
                "id": "9381",
                "name": "The 0.5s",
                "first_name": "Andy ",
                "last_name": "White",
                "total": "285",
                "league_size": "5",
                "squad_size": "14",
                "transfers": "9",
                "weekend_changes": "1",
                "ranking_points": "19727.00",
                "position": "8"
            },
            {
                "id": "2930",
                "name": "Looprevil FC",
                "first_name": "Justin",
                "last_name": "Lotis",
                "total": "275",
                "league_size": "7",
                "squad_size": "16",
                "transfers": "2",
                "weekend_changes": "1",
                "ranking_points": "19471.88",
                "position": "9"
            },
            {
                "id": "8833",
                "name": "VAR",
                "first_name": "Tom",
                "last_name": "Lucas",
                "total": "284",
                "league_size": "6",
                "squad_size": "17",
                "transfers": "5",
                "weekend_changes": "1",
                "ranking_points": "19375.28",
                "position": "10"
            }
        ]
    }
}
```
