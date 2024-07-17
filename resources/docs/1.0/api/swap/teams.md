# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Get All Teams](#get_teams)

<a name="get_teams"></a>
## Get All Teams

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/swaps/getTeams`|`Bearer Token`|

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
    "data": [
        {
            "id": 1611,
            "name": "Adams Family Values",
            "manager_id": 1481,
            "crest_id": null,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "232d4207-bdf1-4445-ac3e-ad85eb4956fc",
            "team_budget": "0.40",
            "is_legacy": 1,
            "season_quota_used": 4,
            "monthly_quota_used": 0,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-01 00:00:04",
            "pivot": {
                "division_id": 223,
                "team_id": 1611,
                "payment_id": 3108,
                "season_id": 30
            }
        },
        {
            "id": 1612,
            "name": "On the Head Son.",
            "manager_id": 1480,
            "crest_id": 5,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "8366dbad-646f-4d76-97dd-7239fe1122d6",
            "team_budget": "7.65",
            "is_legacy": 1,
            "season_quota_used": 7,
            "monthly_quota_used": 2,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-15 15:35:38",
            "pivot": {
                "division_id": 223,
                "team_id": 1612,
                "payment_id": 3109,
                "season_id": 30
            }
        },
        {
            "id": 1613,
            "name": "Où est Pepe",
            "manager_id": 1479,
            "crest_id": null,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "463bd8a1-03f2-49c1-971c-0662029da020",
            "team_budget": "0.80",
            "is_legacy": 1,
            "season_quota_used": 7,
            "monthly_quota_used": 2,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-15 15:35:38",
            "pivot": {
                "division_id": 223,
                "team_id": 1613,
                "payment_id": 3110,
                "season_id": 30
            }
        },
        {
            "id": 1614,
            "name": "Mina Colada",
            "manager_id": 300,
            "crest_id": null,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "0626f951-f597-4dbf-b62a-0d2671bdd7ad",
            "team_budget": "6.00",
            "is_legacy": 1,
            "season_quota_used": 5,
            "monthly_quota_used": 2,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-08 14:03:41",
            "pivot": {
                "division_id": 223,
                "team_id": 1614,
                "payment_id": 3107,
                "season_id": 30
            }
        },
        {
            "id": 1615,
            "name": "The Be Sharps",
            "manager_id": 2398,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "b6e37d6a-df29-4d96-8b1b-aaa0b9e7a1f0",
            "team_budget": "4.90",
            "is_legacy": 1,
            "season_quota_used": 7,
            "monthly_quota_used": 1,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-01 08:16:22",
            "pivot": {
                "division_id": 223,
                "team_id": 1615,
                "payment_id": 3117,
                "season_id": 30
            }
        },
        {
            "id": 1616,
            "name": "Gentleman's Grealish",
            "manager_id": 2257,
            "crest_id": 26,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "0aacabf5-9722-4f56-9e50-0cb0ec3cbd1f",
            "team_budget": "0.45",
            "is_legacy": 1,
            "season_quota_used": 1,
            "monthly_quota_used": 0,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-01 00:00:04",
            "pivot": {
                "division_id": 223,
                "team_id": 1616,
                "payment_id": 3118,
                "season_id": 30
            }
        },
        {
            "id": 1617,
            "name": "The Moura, The Merrier",
            "manager_id": 6,
            "crest_id": 18,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "cb103b0c-7fef-4c9f-9ad4-70808c1cb64d",
            "team_budget": "7.80",
            "is_legacy": 1,
            "season_quota_used": 7,
            "monthly_quota_used": 3,
            "created_at": "2019-07-09 13:33:49",
            "updated_at": "2019-11-15 15:35:38",
            "pivot": {
                "division_id": 223,
                "team_id": 1617,
                "payment_id": 3106,
                "season_id": 30
            }
        },
        {
            "id": 3763,
            "name": "Ibe Made A Huge Mistake",
            "manager_id": 2510,
            "crest_id": null,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "9dba8911-6e4a-413b-8fd3-4af615dd36bd",
            "team_budget": "5.45",
            "is_legacy": 1,
            "season_quota_used": 10,
            "monthly_quota_used": 0,
            "created_at": "2019-07-09 13:34:13",
            "updated_at": "2019-11-01 00:00:04",
            "pivot": {
                "division_id": 223,
                "team_id": 3763,
                "payment_id": 3128,
                "season_id": 30
            }
        },
        {
            "id": 4047,
            "name": "Ray Bloody Purchase",
            "manager_id": 2287,
            "crest_id": 34,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "cd8b18c3-93b8-42f7-a1f3-c3dde9136513",
            "team_budget": "0.75",
            "is_legacy": 1,
            "season_quota_used": 7,
            "monthly_quota_used": 4,
            "created_at": "2019-07-09 13:34:16",
            "updated_at": "2019-11-15 15:35:38",
            "pivot": {
                "division_id": 223,
                "team_id": 4047,
                "payment_id": 3119,
                "season_id": 30
            }
        },
        {
            "id": 5870,
            "name": "When Harry met Shaqiri",
            "manager_id": 5893,
            "crest_id": 5,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "75ce9a54-5ce2-4437-9a83-fdf1364beb1a",
            "team_budget": "0.80",
            "is_legacy": 1,
            "season_quota_used": 0,
            "monthly_quota_used": 0,
            "created_at": "2019-07-09 13:34:38",
            "updated_at": "2019-11-01 00:00:04",
            "pivot": {
                "division_id": 223,
                "team_id": 5870,
                "payment_id": 3115,
                "season_id": 30
            }
        },
        {
            "id": 9709,
            "name": "Harvey's Team",
            "manager_id": 30641,
            "crest_id": 5,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "3dfdcc21-7532-4fef-b8e9-55eb5a330917",
            "team_budget": "0.00",
            "is_legacy": 0,
            "season_quota_used": 0,
            "monthly_quota_used": 0,
            "created_at": "2019-08-04 10:35:24",
            "updated_at": "2019-11-01 00:00:04",
            "pivot": {
                "division_id": 223,
                "team_id": 9709,
                "payment_id": null,
                "season_id": 30
            }
        }
    ]
}
```
