# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Team Payment List](#team_payment_list)

<a name="team_payment_list"></a>
## Team Payment List

Team List with Payment Details - Pre auction State. Pre- auction state is when date & auction closing date are in future.  

### Endpoint

> {warning} Team Payment List can also be used for future if league not in pre-auction state and any team is unpaid.

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/preauction/teams`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
    "data": {
      "price": "30.00",
      "paid_teams_count": 5,
      "total_teams_count": 7,
      "teams": [
          {
              "id": 126,
              "division_id": 2,
              "team_id": 126,
              "season_id": 19,
              "payment_id": null,
              "number": null,
              "is_paid": true,
              "team": {
                  "id": 126,
                  "name": "test Championship",
                  "manager_id": 39,
                  "crest_id": 1,
                  "pitch_id": null,
                  "is_approved": true,
                  "is_ignored": false,
                  "uuid": "8b23183f-dd27-4ee5-a634-90d194467b83",
                  "team_budget": null,
                  "created_at": "2019-03-14 12:48:18",
                  "updated_at": "2019-03-20 11:12:35",
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
                          "last_login_at": "2019-05-28 14:44:21",
                          "provider": "email",
                          "provider_id": null,
                          "remember_url": null,
                          "push_registration_id": null,
                          "created_at": "2019-03-13 13:25:52",
                          "updated_at": "2019-05-28 14:44:21"
                      }
                  }
              }
          }
      ],
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

> {info} The team list is to be shown with payment status, as per the PRE-2 of Pre-auction state mock-up.


