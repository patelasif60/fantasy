# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Swap Players](#swap_players)

<a name="swap_players"></a>
## Swap Players

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/transfers/swaps/swap_players`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

```json
{
    "swap_data": [
        {
            "playerOut": "74",
            "playerOutTeam": "174",
            "playerOutPrice": "2",
            "playerIn": "282",
            "playerInTeam": "175",
            "playerInPrice": "3"
        },
        {
            "playerOut": "121",
            "playerOutTeam": "174",
            "playerOutPrice": "3",
            "playerIn": "8",
            "playerInTeam": "175",
            "playerInPrice": "4"
        }
    ]
}
```

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`swap_data`|JSON|`required`|Ex:`[{"playerOut":"74","playerOutTeam":"174","playerOutPrice":"2","playerIn":"282","playerInTeam":"175","playerInPrice":"3"},{"playerOut":"121","playerOutTeam":"174","playerOutPrice":"3","playerIn":"8","playerInTeam":"175","playerInPrice":"4"}]`|



> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Swaps were successfully processed. Please note that pending SuperSubs have been cancelled."
}
```

> {danger} Error Response if miss criteria

Code `422`

Reason `Update Error`

Content

```json
{
    "status": "error",
    "message": "Invalid Formation. Swaps were not successfully processed."
}
```

```json
{
    "status": "error",
    "message": "Team budget is not enough. Swaps were not successfully processed."
}
```

```json
{
    "status": "error",
    "message": "Club quota is full. Swaps were not successfully processed."
}
```