# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_update"></a>
## League update

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{id}/settings`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
        "name": "",
        "introduction": "",
        "parent_division_id": null,
        "auction_types": "",
        "auction_date": null,
        "pre_season_auction_budget": null,
        "pre_season_auction_bid_increment": null,
        "budget_rollover": null,
        "seal_bids_budget": null,
        "seal_bid_increment": null,
        "seal_bid_minimum": null,
        "manual_bid": "",
        "first_seal_bid_deadline": null,
        "seal_bid_deadline_repeat": null,
        "max_seal_bids_per_team_per_round": null,
        "money_back": null,
        "tie_preference": null,
        "rules": null,
        "default_squad_size": null,
        "default_max_player_each_club": null,
        "available_formations": null,
        "defensive_midfields": null,
        "merge_defenders": null,
        "allow_weekend_changes": null,
        "enable_free_agent_transfer": null,
        "free_agent_transfer_authority": null,
        "free_agent_transfer_after": null,
        "season_free_agent_transfer_limit": null,
        "monthly_free_agent_transfer_limit": null,
        "co_chairman_id": null,
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
|`introduction`|String|`null`|Ex:`Test`|
|`parent_division_id`|Integer|`null`|Ex:`1`|
|`auction_types`|Enum|`null`|Ex:`Live Online`|
|`auction_date`|Datetime|`null`|Ex:`31/01/2019 11:23:55`|
|`pre_season_auction_budget`|Integer|`null`|Ex:`100`|
|`pre_season_auction_bid_increment`|Integer|`null`|Ex:`200`|
|`budget_rollover`|Enum|`null`|Ex:`Yes or No`|
|`seal_bids_budget`|Integer|`null`|Ex:`Seal 1`|
|`seal_bid_increment`|Integer|`null`|Ex:`1`|
|`seal_bid_minimum`|Integer|`null`|Ex:`1`|
|`manual_bid`|Enum|`null`|Ex:`Yes or No`|
|`first_seal_bid_deadline`|Datetime|`null`|Ex:`31/01/2019 11:23:55`|
|`seal_bid_deadline_repeat`|Enum|`null`|Ex:`Don’t repeat`|
|`max_seal_bids_per_team_per_round`|Integer|`null`|Ex:`1`|
|`money_back`|Enum|`null`|Ex:`100% of original auction price`|
|`tie_preference`|Enum|`null`|Ex:`No tie preference`|
|`rules`|String|`null`|Ex:`Free text`|
|`default_squad_size`|Integer|`null`|Ex:`max:18`|
|`default_max_player_each_club`|Integer|`null`|Ex:`min:1`|
|`available_formations`|Array|`null`|Ex:`Select from formation array "4-3-3"`|
|`defensive_midfields`|Enum|`null`|Ex:`Yes or No`|
|`merge_defenders`|Enum|`null`|Ex:`Yes or No`|
|`allow_weekend_changes`|Enum|`null`|Ex:`Yes or No`|
|`enable_free_agent_transfer`|Enum|`null`|Ex:`Yes or No`|
|`free_agent_transfer_authority`|Enum|`null`|Ex:`Chairman`|
|`free_agent_transfer_after`|Enum|`null`|Ex:`Auction end`|
|`season_free_agent_transfer_limit`|Integer|`null`|Ex:`1`|
|`monthly_free_agent_transfer_limit`|Integer|`null`|Ex:`1`|
|`co_chairman_id`|Array|`null`|Ex:`[20,34]`|
|`auction_venue`|String|`null`|Ex:`UK`|
|`auctioneer_id`|Integer|`null`|Ex:`1`|
|`allow_passing_on_nominations`|Enum|`null`|Ex:`Yes or No`|
|`remote_nomination_time_limit`|Integer|`null`|Ex:`1`|
|`remote_bidding_time_limit`|Integer|`null`|Ex:`1`|
|`allow_managers_to_enter_own_bids`|Enum|`null`|Ex:`Yes or No`|
|`auctionRounds`|Json|`null`|Ex:`[{"id":58},{"id":60}]`|


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
    "error": "Not authorized.."
}
```

