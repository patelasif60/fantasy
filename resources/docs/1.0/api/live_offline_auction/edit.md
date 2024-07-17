# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_european_cup_update"></a>
## Update Team Player

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/team/{team}/edit`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`old_amount`|Integer|`required`|Ex:`1`|
|`amount`|Integer|`required`|Ex:`1`|
|`player_id`|Integer|`required`|Ex:`1`|

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
    "status": "error",
    "message": {
        "old_amount": [
            "The old amount field is required."
        ],
        "amount": [
            "The amount field is required."
        ],
        "player_id": [
            "The player id field is required."
        ]
    }
}
```

> {danger} Error Response if miss criteria

Code `422`

Reason `Update Error`

Content

```json
{
    "status": "error",
    "message": "Team budget is not enough"
}
```

```json
{
    "status": "error",
    "message": "Default squad size error"
}
```

```json
{
    "status": "error",
    "message": "Club quota is full"
}
```

```json
{
    "status": "error",
    "message": "Invalid formation"
}
```

```json
{
    "status": "error",
    "message": "Invalid request"
}
```
