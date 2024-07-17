# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Teams

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{divisionId}/sealed/bids/teams`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

> {success} Success Response

Code `200`

Content

```json
{
    "teams": [
        {
            "id": 170,
            "name": "Matt's Team",
            "manager_id": 37,
            "crest_id": 1,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "5a8e7dfd-f230-43b6-ba07-25585e9264fe",
            "team_budget": "198.00",
            "created_at": "2019-05-13 10:41:26",
            "updated_at": "2019-05-14 07:41:10",
            "tieOrder": "4",
            "first_name": "Matt",
            "last_name": "Sims",
            "bidsInRound": 0,
            "bidsWin": 1,
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/1/conversions/859f20049f4b184f79cd31f1e150ce80-thumb.jpg",
            "budget": 198
        },
        {
            "id": 171,
            "name": "Johan's Team",
            "manager_id": 35,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "170a0646-1a90-4fe1-9b32-c420e8577bbe",
            "team_budget": "200.00",
            "created_at": "2019-05-13 10:41:49",
            "updated_at": "2019-05-14 07:39:14",
            "tieOrder": "2",
            "first_name": "Johan",
            "last_name": "Haynes",
            "bidsInRound": 0,
            "bidsWin": 0,
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/2/conversions/ebd4e26a25fba430a617378d0ef1895f-thumb.jpg",
            "budget": 200
        },
        {
            "id": 172,
            "name": "Richard's Team",
            "manager_id": 34,
            "crest_id": 3,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "3bee10d0-d886-4b5b-ba7c-ab5ec3470cce",
            "team_budget": "200.00",
            "created_at": "2019-05-13 10:42:09",
            "updated_at": "2019-05-14 07:39:14",
            "tieOrder": "1",
            "first_name": "Richard",
            "last_name": "Stenson",
            "bidsInRound": 0,
            "bidsWin": 0,
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/3/conversions/21f2b1f541739d592e19cdcd5e56ebbb-thumb.jpg",
            "budget": 200
        },
        {
            "id": 173,
            "name": "Ben's Team",
            "manager_id": 33,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "78f71171-ea69-448f-bd8d-eda3b2f5e4cc",
            "team_budget": "200.00",
            "created_at": "2019-05-13 10:42:27",
            "updated_at": "2019-05-14 07:39:14",
            "tieOrder": "3",
            "first_name": "Ben",
            "last_name": "Grout",
            "bidsInRound": 0,
            "bidsWin": 0,
            "crest": "https://fantasyleague-qa.s3.amazonaws.com/4/conversions/2ee6a052cd140814c6ef69739886b198-thumb.jpg",
            "budget": 200
        }
    ],
    "round": {
        "id": 41,
        "division_id": 40,
        "start": "2019-05-02 07:39:23",
        "is_start": true,
        "end": "2019-05-03 08:39:23",
        "is_end": true,
        "number": "2"
    },
    "previousEndRound": {
        "id": 41,
        "division_id": 40,
        "start": "2019-05-02 07:39:23",
        "is_start": true,
        "end": "2019-05-03 08:39:23",
        "is_end": true,
        "number": "2"
    },
    "currentDateTime": "2019-05-14T07:41:17.393506Z",
    "ownLeague": true,
    "auction_start": "2019-05-14 07:39:23",
    "is_auction_start": true,
    "auction_end": null,
    "is_auction_end": false,
    "manual_bid": false
}
```
