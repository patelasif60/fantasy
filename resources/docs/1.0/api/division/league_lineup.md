# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [League approved team](#approved_team)

<a name="approved_team"></a>
## League approved team

On the basis of the league you will get first approved team for the league

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/first_approved_team`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "team": {
        "id": 2435,
        "name": "Kolobos PFC",
        "manager_id": 6,
        "crest_id": null,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "121623c5-ab14-46f1-9b63-ebb34cba3fe1",
        "team_budget": "162.00",
        "is_legacy": 1,
        "season_quota_used": 4,
        "monthly_quota_used": 0,
        "created_at": "2019-07-09 13:33:56",
        "updated_at": "2020-02-01 00:00:05",
        "pivot": {
            "division_id": 930,
            "team_id": 2435,
            "payment_id": 3072,
            "season_id": 30
        }
    }
}
```
