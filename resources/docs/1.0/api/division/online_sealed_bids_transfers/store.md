# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Bids Store

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/league/{division}/transfers/sealed/bids/players/{team}/data/store`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|
|:-|:-|:-|
|`json_data`|Json||`` |

Pass data in below format in api to store bids or update

```json
{
    "json_data": [
            {
                "id":"42602",
                "club_id":"15",
                "club_id_out":"17",
                "oldPlayerId":"553",
                "newPlayerId":"500",
                "oldPlayerAmount":"1.00",
                "newPlayerAmount":"0.00"
            },
            {
                "id":"42603",
                "club_id":"7",
                "club_id_out":"7",
                "oldPlayerId":"220",
                "newPlayerId":"224",
                "oldPlayerAmount":"4.00",
                "newPlayerAmount":"0.00"
            },
            {
                "id":"42604",
                "club_id":"7",
                "club_id_out":"11",
                "oldPlayerId":"352",
                "newPlayerId":"247",
                "oldPlayerAmount":"15.00",
                "newPlayerAmount":"0.00"
            },
            {
                "id":"42605",
                "club_id":"50",
                "club_id_out":"12",
                "oldPlayerId":"380",
                "newPlayerId":"775",
                "oldPlayerAmount":"25.00",
                "newPlayerAmount":"1200.00"
            }
        ]
}
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been saved successfully."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error",
    "message": {
        "json_data_budget": [
            "Team budget is not enough"
        ]
    }
}
```