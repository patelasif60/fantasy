# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Invite Friends](#invite_friends)

<a name="invite_friends"></a>
## Invite Friends

Points to be shown to a team manager (not a chairman) when a league is in preauction state

### Endpoint

> {warning} Please note that this link will only be visible in Preauction state.

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/preauction/invite/data`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
    "data": {
        "code": "3295C7",
        "url": "https:/fantasyleague.aecordigitalqa.com/api/manage/division/join/a/league/3295C7",
        "division": {
            "id": 66,
            "name": "my test ever League",
            "uuid": "ca44cd98-050e-4269-9b78-a99e44a2cbb0",
            "chairman_id": 39,
            "package_id": 8,
            "introduction": "",
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null,
            "auction_date": "2019-06-06 15:53:56",
            "pre_season_auction_budget": null,
            "pre_season_auction_bid_increment": null,
            "budget_rollover": null,
            "seal_bids_budget": null,
            "seal_bid_increment": null,
            "seal_bid_minimum": null,
            "manual_bid": null,
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
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "created_at": "2019-05-22 10:44:13",
            "updated_at": "2019-05-22 10:44:13",
            "auction_venue": null,
            "auctioneer_id": 39,
            "auction_closing_date": "2019-06-06 15:53:56",
            "is_round_process": false,
            "consumer": {
                "id": 39,
                "user_id": 54,
                "dob": "1991-06-04 00:00:00",
                "address_1": "Address",
                "address_2": null,
                "town": null,
                "county": null,
                "post_code": "22222",
                "country": null,
                "telephone": null,
                "country_code": "+44",
                "favourite_club": "Barnsley FC",
                "introduction": null,
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "created_at": "2019-03-13 13:26:05",
                "updated_at": "2019-05-22 10:43:32",
                "user": {
                    "id": 54,
                    "first_name": "Sharvari",
                    "last_name": "Upasani",
                    "email": "supasani@aecordigital.com",
                    "username": "nameme",
                    "email_verified_at": null,
                    "status": "Active",
                    "last_login_at": "2019-05-30 06:25:49",
                    "provider": "email",
                    "provider_id": null,
                    "remember_url": null,
                    "push_registration_id": null,
                    "created_at": "2019-03-13 13:25:52",
                    "updated_at": "2019-05-30 06:25:49"
                }
            }
        }
    }
}
```
> {info} Invite Friends -> is to be shown in the mentioned screens as per the PRE-2 Copy of Pre-auction state mock-up.

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
