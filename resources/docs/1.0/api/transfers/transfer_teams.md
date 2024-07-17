# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
## League Team List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/transfers/transfer_teams`|`Bearer Token`|


### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
 {
    "status": "success",
    "data": [
        {
            "id": 138,
            "name": "Ben 1's Team",
            "manager_id": 33,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "64c1b537-c818-444e-b808-c54488ffe16e",
            "team_budget": "154.00",
            "created_at": "2019-04-25 09:38:12",
            "updated_at": "2019-05-27 08:54:24",
            "first_name": "Ben",
            "last_name": "Grout",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/2/conversions/ebd4e26a25fba430a617378d0ef1895f-thumb.jpg",
            "defaultSquadSize": 15,
            "team_players_count": 15
        }
    ]
}
```
