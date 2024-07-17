# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
## League Team List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/auction/teams`|`Bearer Token`|


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
            "first_name": "James",
            "last_name": "Lovell",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/2202/conversions/a-southampton-fc-logo-thumb.jpg",
            "defaultSquadSize": 15,
            "team_players_count": 15,
            "media": [
                {
                    "id": 2202,
                    "model_type": "App\\Models\\Team",
                    "model_id": 1611,
                    "collection_name": "crest",
                    "name": "a-southampton-fc-logo",
                    "file_name": "a-southampton-fc-logo.png",
                    "mime_type": "image/png",
                    "disk": "s3",
                    "size": 6755,
                    "manipulations": {
                        "thumb": {
                            "manualCrop": "250,250,0,0"
                        }
                    },
                    "custom_properties": {
                        "generated_conversions": {
                            "thumb": true
                        }
                    },
                    "responsive_images": [],
                    "order_column": 2144,
                    "created_at": "2019-08-04 16:48:48",
                    "updated_at": "2019-08-04 16:48:48"
                }
            ]
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
            "first_name": "Karl",
            "last_name": "Wyatt",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1030/conversions/FL_Team-Badge-Icons_AW-08-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
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
            "first_name": "Shady",
            "last_name": "",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1794/conversions/YSektZi6_400x400-thumb.jpg",
            "defaultSquadSize": 15,
            "team_players_count": 15,
            "media": [
                {
                    "id": 1794,
                    "model_type": "App\\Models\\Team",
                    "model_id": 1613,
                    "collection_name": "crest",
                    "name": "YSektZi6_400x400",
                    "file_name": "YSektZi6_400x400.jpg",
                    "mime_type": "image/jpeg",
                    "disk": "s3",
                    "size": 30027,
                    "manipulations": {
                        "thumb": {
                            "manualCrop": "359,359,0,0"
                        }
                    },
                    "custom_properties": {
                        "generated_conversions": {
                            "thumb": true
                        }
                    },
                    "responsive_images": [],
                    "order_column": 1742,
                    "created_at": "2019-07-31 13:01:16",
                    "updated_at": "2019-07-31 13:01:16"
                }
            ]
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
            "first_name": "Stuart",
            "last_name": "Sims",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/2033/conversions/E7A8D7E4-8000-4BE0-B79A-C3033C4AC360-thumb.jpg",
            "defaultSquadSize": 15,
            "team_players_count": 15,
            "media": [
                {
                    "id": 2033,
                    "model_type": "App\\Models\\Team",
                    "model_id": 1614,
                    "collection_name": "crest",
                    "name": "E7A8D7E4-8000-4BE0-B79A-C3033C4AC360",
                    "file_name": "E7A8D7E4-8000-4BE0-B79A-C3033C4AC360.png",
                    "mime_type": "image/png",
                    "disk": "s3",
                    "size": 1921742,
                    "manipulations": {
                        "thumb": {
                            "manualCrop": "750,750.00520788623,0,419.03410879332"
                        }
                    },
                    "custom_properties": {
                        "generated_conversions": {
                            "thumb": true
                        }
                    },
                    "responsive_images": [],
                    "order_column": 1978,
                    "created_at": "2019-08-02 11:27:23",
                    "updated_at": "2019-08-02 11:27:24"
                }
            ]
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
            "first_name": "Paul",
            "last_name": "Warner",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1028/conversions/FL_Team-Badge-Icons_AW-07-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
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
            "first_name": "Lloydo",
            "last_name": "",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1048/conversions/s5-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
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
            "first_name": "Matt",
            "last_name": "Sims",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1059/conversions/FL_Team-Badge-Icons_AW-39-thumb-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
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
            "first_name": "Joe",
            "last_name": "Towey",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1710/conversions/gallery_hero_1ec97804-37f9-4840-b799-077733408136-thumb.jpg",
            "defaultSquadSize": 15,
            "team_players_count": 15,
            "media": [
                {
                    "id": 1710,
                    "model_type": "App\\Models\\Team",
                    "model_id": 3763,
                    "collection_name": "crest",
                    "name": "gallery_hero_1ec97804-37f9-4840-b799-077733408136",
                    "file_name": "gallery_hero_1ec97804-37f9-4840-b799-077733408136.jpg",
                    "mime_type": "image/jpeg",
                    "disk": "s3",
                    "size": 60033,
                    "manipulations": {
                        "thumb": {
                            "manualCrop": "586,586,55,49"
                        }
                    },
                    "custom_properties": {
                        "generated_conversions": {
                            "thumb": true
                        }
                    },
                    "responsive_images": [],
                    "order_column": 1658,
                    "created_at": "2019-07-30 13:48:06",
                    "updated_at": "2019-07-30 13:48:06"
                }
            ]
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
            "first_name": "Maff",
            "last_name": "Nesbitt",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1055/conversions/FL_Team-Badge-Icons_AW-36-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
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
            "first_name": "John",
            "last_name": "Bloomfield",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1030/conversions/FL_Team-Badge-Icons_AW-08-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
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
            "first_name": "Harvey",
            "last_name": "Pringle",
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1030/conversions/FL_Team-Badge-Icons_AW-08-thumb.png",
            "defaultSquadSize": 15,
            "team_players_count": 15
        }
    ]
}
```
