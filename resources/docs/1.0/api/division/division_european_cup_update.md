# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_european_cup_update"></a>
## League European Cup Updtae

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{division}/europeancup/teams/update`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`divisionColumn`|Enum|`required`|Ex:`champions_league_team,europa_league_team_1,europa_league_team_2`|
|`team`|Integer|`required`|Ex:`1`|

> {success} Success Response

Code `200`

Content

```json
{
    "success": "Details have been updated successfully."
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
        "divisionColumn": [
            "The selected division column is invalid."
        ],
        "team": [
            "The team field is required."
        ]
    }
}
```

> {danger} Error Response

Code `422`

Reason `Update Error`

Content

```json
{
    "error": "Details could not be updated at this time. Please try again later."
}
```
