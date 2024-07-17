# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Bids Update

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/league/{DivisionId}/sealed/bids/players/{TeamId}/data/update`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`bid_id`|Integer||`1` | SealBid Id
|`player_id`|Integer||`1` | Player id
|`amount`|Numberic||`10.00` | Amount

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been updated successfully."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "bid_id": [
            "The bid id field is required."
        ],
        "player_id": [
            "The player id has already been taken."
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
