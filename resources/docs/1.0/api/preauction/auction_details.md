# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Auction Details](#auction_details)

<a name="auction_details"></a>
## Auction Details

Auction Details on Auction Tab - Pre auction State

### Endpoint

> {warning} Please note that this screen will only be visible on Auction Tab in Preauction state.

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/preauction/auction`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
    "data": {
        "type": "Online sealed bids",
        "startTime": "2019-06-06 15:53:56",
        "venue": "uk",
        "budget": 200,
        "bidIncrement": "0.50",
        "isOnNominations": null,
        "nominationLimit": null,
        "bidsLimit": null,
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
            "is_round_process": false,
            "package": {
                "id": 5,
                "is_enabled": "Yes",
                "name": "Novice 18/19",
                "display_name": "Novice",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "available_new_user": "Yes",
                "price": "0.00",
                "private_league": "Yes",
                "minimum_teams": 5,
                "maximum_teams": 10,
                "auction_types": [
                    "Online sealed bids",
                    "Live online",
                    "Live offline"
                ],
                "pre_season_auction_budget": 200,
                "pre_season_auction_bid_increment": 1,
                "budget_rollover": "No",
                "seal_bids_budget": 50,
                "seal_bid_increment": "0.50",
                "seal_bid_minimum": 0,
                "manual_bid": "No",
                "first_seal_bid_deadline": "2018-08-03 12:00:00",
                "seal_bid_deadline_repeat": "everyMonth",
                "max_seal_bids_per_team_per_round": 5,
                "money_back": "none",
                "tie_preference": "lowerLeaguePositionWins",
                "custom_squad_size": "No",
                "default_squad_size": 15,
                "custom_club_quota": "No",
                "default_max_player_each_club": 2,
                "available_formations": [
                    "442",
                    "451",
                    "433",
                    "532",
                    "541"
                ],
                "defensive_midfields": "No",
                "merge_defenders": "Yes",
                "enable_free_agent_transfer": "No",
                "free_agent_transfer_authority": "chairman",
                "free_agent_transfer_after": "seasonStart",
                "season_free_agent_transfer_limit": 20,
                "monthly_free_agent_transfer_limit": 5,
                "allow_weekend_changes": "No",
                "allow_custom_cup": "Yes",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "Yes",
                "allow_europa_league": "Yes",
                "allow_pro_cup": "Yes",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "digital_prize_type": "Basic",
                "allow_custom_scoring": "No",
                "created_at": "2019-03-13 13:17:26",
                "updated_at": "2019-05-20 16:13:13"
            }
        }
    }
}
```
> {info} The auction details is to be shown on Auction Tab, as per the PRE-4 of Pre-auction state mock-up.

> {danger} Error Response

Code `422`

Reason `League/Team is in post auction state`

Content

```json
{
    "status": "error",
    "message": "Not authorized."
}
```
