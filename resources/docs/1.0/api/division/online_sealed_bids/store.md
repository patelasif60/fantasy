# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Bids Store

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/league/{divisionId}/sealed/bids/players/{TeamId}/data/store`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`player_id`|Integer||`1` | Player id
|`amount`|Numberic||`10.00` | Amount

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
        "player_id": [
            "The player id field is required."
        ],
        "amount": [
            "The amount field is required."
        ]
    }
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
        "player_id": [
            "Default squad size error",
            "Invalid formation"
        ]
    }
}
```
