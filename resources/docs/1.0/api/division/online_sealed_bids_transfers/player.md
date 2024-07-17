# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Player details

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/league/{division}/transfers/sealed/bids/{team}/player/details`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`newPlayerId`|Integer||`1` | New player id
|`oldPlayerId`|Integer||`1` | Old player id
|`amount`|Numberic||`10.00` | Amount

> {success} Success Response

Code `200`

Content

```json
{
    "newValue": {
        "player_id": 500,
        "player_first_name": "Ciaran",
        "player_last_name": "Clark",
        "short_code": "NEW",
        "position": "Centre-back (CB)",
        "club_name": "Newcastle United",
        "club_id": 15,
        "playerPositionShort": "CB",
        "amount": "0"
    },
    "playerKey": "CB",
    "newPlayerId": "500",
    "oldPlayerId": "553",
    "isGk": "GK",
    "bidIncrementDecimalPlace": 2,
    "playerInitialCount": []
}
```