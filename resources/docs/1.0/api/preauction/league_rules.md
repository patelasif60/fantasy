# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [League Rules](#league_rules)

<a name="league_rules"></a>
## League Rules

League Rules to be shown to a team manager (not a chairman) when a league is in preauction state

### Endpoint

> {warning} Please note that this link will only be visible in Preauction state.

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/preauction/rules/data`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
    "data": {
        "budget": 50,
        "seasonBudget": 200,
        "isBudgetRollover": "Yes",
        "quota": 2,
        "squad": 15,
        "formations": "4-4-2, 4-5-1, 4-3-3, 5-3-2, 5-4-1",
        "hasWeekendChanges": "No",
        "seasonTransfer": 20,
        "monthlyTransfer": 5,
        "isAllowedTransfer": "No",
        "division": {
            "id": 2,
            "name": "A Really Loooooooong name for a league",
            "uuid": "0650b39a-69a5-46f9-8b5a-7330e8d76018",
            "chairman_id": 35,
            "package_id": 5,
            "introduction": null,
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null,
            "auction_date": "2019-06-06 15:53:56",
            "pre_season_auction_budget": 200,
            "pre_season_auction_bid_increment": 1,
            "budget_rollover": "Yes",
            "seal_bids_budget": 50,
            "seal_bid_increment": "0.50",
            "seal_bid_minimum": 0,
            "manual_bid": "Yes",
            "first_seal_bid_deadline": "2019-03-18 14:52:43",
            "seal_bid_deadline_repeat": "everyMonth",
            "max_seal_bids_per_team_per_round": 5,
            "money_back": "none",
            "tie_preference": "no",
            "rules": null,
            "default_squad_size": 15,
            "default_max_player_each_club": 2,
            "available_formations": [
                "442",
                "451",
                "433",
                "532",
                "541"
            ],
            "defensive_midfields": "Yes",
            "merge_defenders": "No",
            "allow_weekend_changes": "No",
            "enable_free_agent_transfer": "No",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "champions_league_team": 10,
            "europa_league_team_1": 6,
            "europa_league_team_2": 8,
            "created_at": "2019-03-13 13:17:28",
            "updated_at": "2019-05-03 13:35:06",
            "auction_venue": "uk",
            "auctioneer_id": 33,
            "auction_closing_date": "2019-06-06 15:53:56",
            "is_round_process": false
        }
    }
}
```
> {info} The League Rules is to be shown in the mentioned screens as per the Pre-auction state mock-up.

> {danger} Error Response

Code `422`

Reason `League/Team is in post auction state & user is a chairman of the league.`

Content

```json
{
    "status": "error",
    "message": "Not authorized."
}
```
