# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="auction_update"></a>
## League auction update

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{id}//auction/settings`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
        "name": "",
        "auction_types": "",
        "auction_date": null,
        "pre_season_auction_budget": null,
        "pre_season_auction_bid_increment": null,
        "budget_rollover": null,
        "manual_bid": "",
        "tie_preference": null,
        "auction_venue": null,
        "auctioneer_id": null,
        "allow_passing_on_nominations": null,
        "remote_nomination_time_limit": null,
        "remote_bidding_time_limit":null,
        "allow_managers_to_enter_own_bids":null,
        "auctionRounds":null,
}
```

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`name`|String|`required`|Ex:`Test`|
|`auction_types`|Enum|`null`|Ex:`Live Online`|
|`auction_date`|Datetime|`null`|Ex:`2018-05-04 15:00:00`|
|`pre_season_auction_budget`|Integer|`null`|Ex:`100`|
|`pre_season_auction_bid_increment`|Integer|`null`|Ex:`200`|
|`budget_rollover`|Enum|`null`|Ex:`Yes or No`|
|`manual_bid`|Enum|`null`|Ex:`Yes or No`|
|`tie_preference`|Enum|`null`|Ex:`No tie preference`|
|`auction_venue`|String|`null`|Ex:`UK`|
|`auctioneer_id`|Integer|`null`|Ex:`1`|
|`allow_passing_on_nominations`|Enum|`null`|Ex:`Yes or No`|
|`remote_nomination_time_limit`|Integer|`null`|Ex:`1`|
|`remote_bidding_time_limit`|Integer|`null`|Ex:`1`|
|`allow_managers_to_enter_own_bids`|Enum|`null`|Ex:`Yes or No`|
|`auctionRounds`|Json|`null`|Ex:`[{"id":144,"division_id": 14,"start": "2020-04-19 08:44:47","end": "2020-04-20 08:44:47","number": 1},{"division_id": 14,"start": "2020-04-19 08:44:47","end": "2020-04-20 08:44:47","number": 1}]`|


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
        "champions_league_team": [
            "The champions league team field is required."
        ],
        "europa_league_team_1": [
            "The europa league team 1 field is required."
        ],
        "europa_league_team_2": [
            "The europa league team 2 field is required."
        ]
    }
}
```

> {danger} Error Response

Code `403`

Reason `Update Error`

Content

```json
{
    "status": "error",
    "message": "Not authorized."
}
```

