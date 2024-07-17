# Team API Docs

---

- [Teams Budget](#teams_budget)



<a name="teams_budget"></a>
## Teams Budget list

This will list all teams of current user.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/6/teams/list`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
[
    {
        "id": 38,
        "name": "Willys wonders ride again",
        "manager_id": 548,
        "crest_id": 14,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "18334286-60f6-4501-9fd8-34d29cb637ba",
        "team_budget": "13.00",
        "is_legacy": 1,
        "season_quota_used": 40,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-01 00:00:05",
        "first_name": "Dysleksik and Josh",
        "last_name": "",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 39,
        "name": "Dukla Jablonec",
        "manager_id": 2558,
        "crest_id": 30,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "cd339cd8-aec6-4f5e-8179-fec3d206fcb1",
        "team_budget": "2.00",
        "is_legacy": 1,
        "season_quota_used": 40,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-01 00:00:05",
        "first_name": "Jocky",
        "last_name": " Glover",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 40,
        "name": "Strong Stable Seagulls",
        "manager_id": 2552,
        "crest_id": null,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "5a15f0bb-7d2e-45c3-9b4c-c1f7390f3221",
        "team_budget": "0.00",
        "is_legacy": 1,
        "season_quota_used": 42,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-01 00:00:05",
        "first_name": "Chaika",
        "last_name": "Strika",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 41,
        "name": "Last Season's Bottom Lovers",
        "manager_id": 966,
        "crest_id": 33,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "b1e857d3-f191-4c71-b451-7b08aabe3a50",
        "team_budget": "15.00",
        "is_legacy": 1,
        "season_quota_used": 41,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-01 00:00:05",
        "first_name": "Choirboy",
        "last_name": "",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 42,
        "name": "Inter Beaver",
        "manager_id": 884,
        "crest_id": 11,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "cd37c841-b525-4138-a9bb-c4283e40bd04",
        "team_budget": "0.00",
        "is_legacy": 1,
        "season_quota_used": 44,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-06 10:28:59",
        "first_name": "Q",
        "last_name": "Ball",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 43,
        "name": "Fudgy Fiji Bottom Lovers",
        "manager_id": 865,
        "crest_id": 23,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "c5ccd9e8-aedc-451d-add7-34826f457cac",
        "team_budget": "4.00",
        "is_legacy": 1,
        "season_quota_used": 37,
        "monthly_quota_used": 48,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-02 04:43:42",
        "first_name": "Nutters",
        "last_name": " ",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 45,
        "name": "The Net Prophets",
        "manager_id": 286,
        "crest_id": null,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "12b5e522-48e7-41ae-b903-1d4bbdd03e4d",
        "team_budget": "10.00",
        "is_legacy": 1,
        "season_quota_used": 35,
        "monthly_quota_used": 44,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-05 11:41:17",
        "first_name": "The",
        "last_name": "Ballmaster",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 46,
        "name": "Teens Park Rangers",
        "manager_id": 3271,
        "crest_id": 3,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "b566f637-f5b4-4e23-b62f-a6c84278a401",
        "team_budget": "2.00",
        "is_legacy": 1,
        "season_quota_used": 35,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:33:35",
        "updated_at": "2020-02-01 00:00:05",
        "first_name": "Eddie",
        "last_name": "Ball",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    },
    {
        "id": 4398,
        "name": "Next Season's Bottom Lovers?",
        "manager_id": 5008,
        "crest_id": 2,
        "pitch_id": null,
        "is_approved": true,
        "is_ignored": false,
        "uuid": "4aa8d035-05bb-4f08-b445-b273970a2b44",
        "team_budget": "12.00",
        "is_legacy": 1,
        "season_quota_used": 46,
        "monthly_quota_used": 50,
        "created_at": "2019-07-09 13:34:20",
        "updated_at": "2020-02-01 00:00:05",
        "first_name": "Jon",
        "last_name": "Locke",
        "crest": "http://affan-fantasyleague-api.dev.aecortech.com/assets/frontend/img/default/square/default-thumb-100.png",
        "defaultSquadSize": 15,
        "monthly_free_agent_transfer_limit": 50,
        "season_free_agent_transfer_limit": 50
    }
]
```