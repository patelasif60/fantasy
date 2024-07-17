# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## Custom cup details

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GEt|`api/leagues/5/custom/cups/27/details`|`Bearer Token`|

### URL Params

> {info} 5 will be league id and 27 will be custom cup id.

### Response

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 13,
        "name": "Maisie Fowler",
        "division_id": 5,
        "is_bye_random": true,
        "status": "Active",
        "created_at": {
            "date": "2019-04-01 05:08:29.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2019-04-01 05:12:30.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "teamCount": 12,
        "gameweeks": "Configured",
        "first_round_byes": "Select by manager"
    },
    "teams": [
        {
            "id": 90,
            "custom_cup_id": 13,
            "team_id": 6,
            "is_bye": true,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 6,
                "name": "Ben's Novice Team",
                "manager_id": 33,
                "crest_id": 1,
                "pitch_id": 2,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "abea4eaf-061a-4933-9b4b-17fc89b1a5c8",
                "created_at": "2019-03-12 05:35:03",
                "updated_at": "2019-03-12 05:35:03"
            }
        },
        {
            "id": 91,
            "custom_cup_id": 13,
            "team_id": 9,
            "is_bye": true,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 9,
                "name": "Stuart's Novice Team",
                "manager_id": 38,
                "crest_id": 3,
                "pitch_id": 2,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "1f3402e6-8c5a-4660-9529-ff22c2de5479",
                "created_at": "2019-03-12 05:35:03",
                "updated_at": "2019-03-12 05:35:03"
            }
        },
        {
            "id": 92,
            "custom_cup_id": 13,
            "team_id": 10,
            "is_bye": true,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 10,
                "name": "Matt's Novice Team",
                "manager_id": 37,
                "crest_id": 4,
                "pitch_id": 2,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "be9124cd-7cbb-48f6-ba6c-0591e2642aac",
                "created_at": "2019-03-12 05:35:03",
                "updated_at": "2019-03-12 05:35:03"
            }
        },
        {
            "id": 93,
            "custom_cup_id": 13,
            "team_id": 24,
            "is_bye": true,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 24,
                "name": "Brennan Clowns",
                "manager_id": 29,
                "crest_id": 1,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "78fdcc31-1ae9-46d4-9b9c-50ba26eaac5c",
                "created_at": "2019-03-12 05:35:05",
                "updated_at": "2019-03-12 05:35:05"
            }
        },
        {
            "id": 94,
            "custom_cup_id": 13,
            "team_id": 28,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 28,
                "name": "Icie Team",
                "manager_id": 24,
                "crest_id": 2,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "b0d37a92-d78f-4bbb-bfc5-9b57a8a189aa",
                "created_at": "2019-03-12 05:35:06",
                "updated_at": "2019-03-12 05:35:06"
            }
        },
        {
            "id": 95,
            "custom_cup_id": 13,
            "team_id": 61,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 61,
                "name": "Maynard FC",
                "manager_id": 12,
                "crest_id": 1,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "3e1b4653-aeba-42aa-bc08-44ab387238aa",
                "created_at": "2019-03-12 05:35:10",
                "updated_at": "2019-03-12 05:35:10"
            }
        },
        {
            "id": 96,
            "custom_cup_id": 13,
            "team_id": 63,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 63,
                "name": "Margaret Scintillating Assassins",
                "manager_id": 16,
                "crest_id": 2,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "20ecd81c-c69d-46ee-abc2-6858bcd78106",
                "created_at": "2019-03-12 05:35:11",
                "updated_at": "2019-03-12 05:35:11"
            }
        },
        {
            "id": 97,
            "custom_cup_id": 13,
            "team_id": 66,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 66,
                "name": "Troy Elephants",
                "manager_id": 27,
                "crest_id": 1,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "e9cb5dde-53e2-4bc9-85c9-c82584b4ab14",
                "created_at": "2019-03-12 05:35:11",
                "updated_at": "2019-03-12 05:35:11"
            }
        },
        {
            "id": 98,
            "custom_cup_id": 13,
            "team_id": 67,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 67,
                "name": "Claudine Royals",
                "manager_id": 7,
                "crest_id": 4,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "70f32d08-d17e-41ad-95da-fb0a017e0899",
                "created_at": "2019-03-12 05:35:11",
                "updated_at": "2019-03-12 05:35:11"
            }
        },
        {
            "id": 99,
            "custom_cup_id": 13,
            "team_id": 68,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 68,
                "name": "Javonte Paper Porcupines",
                "manager_id": 4,
                "crest_id": 3,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "086506a2-5a44-4801-9266-4abecd914129",
                "created_at": "2019-03-12 05:35:12",
                "updated_at": "2019-03-12 05:35:12"
            }
        },
        {
            "id": 100,
            "custom_cup_id": 13,
            "team_id": 70,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 70,
                "name": "Josie Scoreless Hyenas",
                "manager_id": 24,
                "crest_id": 3,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "6945c21d-9d54-47d6-998c-927d18b28628",
                "created_at": "2019-03-12 05:35:12",
                "updated_at": "2019-03-12 05:35:12"
            }
        },
        {
            "id": 101,
            "custom_cup_id": 13,
            "team_id": 71,
            "is_bye": false,
            "created_at": "2019-04-01 05:08:29",
            "updated_at": "2019-04-01 05:08:29",
            "team": {
                "id": 71,
                "name": "Bria Enchanting Gang",
                "manager_id": 1,
                "crest_id": 1,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "b0c5a6dd-5aa8-4110-9758-a88047c5cbe7",
                "created_at": "2019-03-12 05:35:12",
                "updated_at": "2019-03-12 05:35:12"
            }
        }
    ]
}
```
