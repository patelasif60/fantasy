# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## Custom cup list

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GEt|`/api/leagues/5/custom/cups`|`Bearer Token`|

### URL Params

> {info} 5 will be league id in URL.

### Response

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 18,
            "name": "First no bye",
            "division_id": 5,
            "is_bye_random": false,
            "status": "Active",
            "created_at": {
                "date": "2019-03-22 10:19:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-03-26 09:33:32.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "teamCount": 4,
            "gameweeks": "Configured",
            "first_round_byes": "Automatic"
        },
        {
            "id": 19,
            "name": "Second Cup with bye",
            "division_id": 5,
            "is_bye_random": true,
            "status": "Pending",
            "created_at": {
                "date": "2019-03-22 10:20:25.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-03-22 10:20:25.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "teamCount": 5,
            "gameweeks": "Configured",
            "first_round_byes": "Select by manager"
        },
        {
            "id": 20,
            "name": "Third with bye",
            "division_id": 5,
            "is_bye_random": true,
            "status": "Active",
            "created_at": {
                "date": "2019-03-22 10:21:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-03-26 09:33:32.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "teamCount": 7,
            "gameweeks": "Configured",
            "first_round_byes": "Select by manager"
        },
        {
            "id": 26,
            "name": "Maya Powers",
            "division_id": 5,
            "is_bye_random": true,
            "status": "Pending",
            "created_at": {
                "date": "2019-03-26 04:57:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-03-26 04:57:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "teamCount": 13,
            "gameweeks": "Configured",
            "first_round_byes": "Select by manager"
        },
        {
            "id": 27,
            "name": "Cherokee Davis",
            "division_id": 5,
            "is_bye_random": true,
            "status": "Pending",
            "created_at": {
                "date": "2019-03-26 05:43:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-03-26 05:43:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "teamCount": 12,
            "gameweeks": "Configured",
            "first_round_byes": "Select by manager"
        }
    ]
}
```
