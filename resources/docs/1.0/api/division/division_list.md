# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
## League List

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues`|`Bearer Token`|

### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 2,
            "name": "Championship",
            "ownLeague": true,
            "package_id": 5,
            "introduction": null,
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "auction_date": "2019-04-26 18:57:19",
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
            "co_chairman_id": [],
            "co_chairman": [],
            "season_start": true,
            "championLeague": 0,
            "europaLeague": 0,
            "europeanCups": true,
            "teams": [
                {
                    "id": 6,
                    "name": "Ben's Novice Team"
                },
                {
                    "id": 7,
                    "name": "Richard's Novice Team"
                },
                {
                    "id": 8,
                    "name": "Johan's Novice Team"
                },
                {
                    "id": 9,
                    "name": "Stuart's Novice Team"
                },
                {
                    "id": 10,
                    "name": "Matt's Novice Team"
                },
                {
                    "id": 126,
                    "name": "test Championship"
                },
                {
                    "id": 127,
                    "name": "New Test Team"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": "Aecor technologies",
            "auction_closing_date": null,
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null,
            "auction_message": true,
            "auction_closed": true
        },
        {
            "id": 18,
            "name": "Johan's League",
            "ownLeague": true,
            "package_id": 5,
            "introduction": "",
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "auction_date": null,
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
            "merge_defenders": "Yes",
            "allow_weekend_changes": "No",
            "enable_free_agent_transfer": "No",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "co_chairman_id": [],
            "co_chairman": [],
            "season_start": true,
            "package": {
                "id": 5,
                "name": "Novice 18/19",
                "display_name": "Novice",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "custom_squad_size": "No",
                "custom_club_quota": "No",
                "allow_custom_cup": "Yes",
                "allow_fa_cup": "No",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "No"
            },
            "championLeague": 0,
            "europaLeague": 0,
            "europeanCups": true,
            "teams": [
                {
                    "id": 140,
                    "name": "Johan's Team"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": null,
            "auction_closing_date": null,
            "allow_passing_on_nominations": "No",
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_message": false,
            "auction_closed": true
        },
        {
            "id": 19,
            "name": "Johan's League1",
            "ownLeague": true,
            "package_id": 5,
            "introduction": "",
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "auction_date": null,
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
            "merge_defenders": "Yes",
            "allow_weekend_changes": "No",
            "enable_free_agent_transfer": "No",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "co_chairman_id": [],
            "co_chairman": [],
            "season_start": true,
            "package": {
                "id": 5,
                "name": "Novice 18/19",
                "display_name": "Novice",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "custom_squad_size": "No",
                "custom_club_quota": "No",
                "allow_custom_cup": "Yes",
                "allow_fa_cup": "No",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "No"
            },
            "championLeague": 0,
            "europaLeague": 0,
            "europeanCups": false,
            "teams": [],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": null,
            "auction_closing_date": null,
            "allow_passing_on_nominations": "No",
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_message": false,
            "auction_closed": true
        },
        {
            "id": 10,
            "name": "Kailee",
            "ownLeague": false,
            "package_id": 7,
            "introduction": "Knave, 'I didn't know how to begin.' For, you see, so many out-of-the-way things had happened lately, that Alice had got to grow up again! Let me.",
            "parent_division_id": 9,
            "auction_types": "Online sealed bids",
            "auction_date": null,
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
            "allow_weekend_changes": "Yes",
            "enable_free_agent_transfer": "Yes",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "co_chairman_id": [
                36
            ],
            "co_chairman": [
                {
                    "id": 36,
                    "user_id": 51,
                    "dob": {
                        "date": "1970-01-04 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "address_1": "126 Test Street",
                    "address_2": "",
                    "town": "Test Town",
                    "county": "",
                    "post_code": "TE5 T8",
                    "country": "UK",
                    "telephone": "",
                    "country_code": "",
                    "favourite_club": "",
                    "introduction": "",
                    "has_games_news": false,
                    "has_fl_marketing": false,
                    "has_third_parities": false,
                    "user": {
                        "id": 51,
                        "first_name": "Stuart",
                        "last_name": "Walsh",
                        "email": "sfnwalsh@me.com",
                        "username": "swalsh",
                        "status": "Active",
                        "last_login_at": null
                    }
                }
            ],
            "season_start": true,
            "package": {
                "id": 7,
                "name": "Pro 18/19",
                "display_name": "Pro",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "custom_squad_size": "No",
                "custom_club_quota": "No",
                "allow_custom_cup": "No",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "Yes"
            },
            "championLeague": 6,
            "europaLeague": 0,
            "europeanCups": true,
            "teams": [
                {
                    "id": 88,
                    "name": "Elna Paper Porcupines"
                },
                {
                    "id": 89,
                    "name": "Raquel Fire Thunderballs"
                },
                {
                    "id": 90,
                    "name": "Naomie Turtles"
                },
                {
                    "id": 91,
                    "name": "Pamela Novelty Blast"
                },
                {
                    "id": 92,
                    "name": "Gabrielle Fire Thunderballs"
                },
                {
                    "id": 93,
                    "name": "Caden Rag Gentlemen"
                },
                {
                    "id": 94,
                    "name": "Neil FC"
                },
                {
                    "id": 95,
                    "name": "Yvonne Bizarre Butchers"
                },
                {
                    "id": 96,
                    "name": "Kenyatta Hurricanes"
                },
                {
                    "id": 97,
                    "name": "Jordane XI"
                },
                {
                    "id": 98,
                    "name": "Elmore Knights"
                },
                {
                    "id": 99,
                    "name": "Stella Novelty Blast"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": null,
            "auction_closing_date": null,
            "allow_passing_on_nominations": "No",
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_message": false,
            "auction_closed": true
        },
        {
            "id": 13,
            "name": "League Seal",
            "ownLeague": false,
            "package_id": 4,
            "introduction": "",
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "auction_date": "2019-04-13 05:11:36",
            "pre_season_auction_budget": 716,
            "pre_season_auction_bid_increment": 2,
            "budget_rollover": "Yes",
            "seal_bids_budget": 408,
            "seal_bid_increment": "4.00",
            "seal_bid_minimum": 71,
            "manual_bid": "Yes",
            "first_seal_bid_deadline": "2019-03-13 13:17:26",
            "seal_bid_deadline_repeat": "dontRepeat",
            "max_seal_bids_per_team_per_round": 1,
            "money_back": "hunderedPercent",
            "tie_preference": "randomlyAllocatedReverses",
            "rules": null,
            "default_squad_size": 14,
            "default_max_player_each_club": 2,
            "available_formations": [
                541,
                442,
                433,
                532,
                451
            ],
            "defensive_midfields": "Yes",
            "merge_defenders": "Yes",
            "allow_weekend_changes": "Yes",
            "enable_free_agent_transfer": "Yes",
            "free_agent_transfer_authority": "coChairman",
            "free_agent_transfer_after": "auctionEnd",
            "season_free_agent_transfer_limit": 826,
            "monthly_free_agent_transfer_limit": 472,
            "co_chairman_id": [],
            "co_chairman": [],
            "season_start": true,
            "package": {
                "id": 4,
                "name": "Emie Ziemann I",
                "display_name": "Ms. Desiree Hilpert II",
                "short_description": "The miserable Hatter dropped his teacup instead of onions.' Seven flung down his cheeks, he went on for some minutes. Alice thought decidedly.",
                "long_description": "While she was surprised to see it written up somewhere.' Down, down, down. Would the fall was over. However, when they liked, and left off staring at the Queen, turning purple. 'I won't!' said.",
                "custom_squad_size": "Yes",
                "custom_club_quota": "Yes",
                "allow_custom_cup": "No",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "Yes",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "Yes"
            },
            "championLeague": 0,
            "europaLeague": 0,
            "europeanCups": true,
            "teams": [
                {
                    "id": 128,
                    "name": "Team Seal"
                },
                {
                    "id": 129,
                    "name": "Team Jhynes"
                },
                {
                    "id": 130,
                    "name": "Team Rstenson"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": null,
            "auction_closing_date": null,
            "allow_passing_on_nominations": "No",
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_message": false,
            "auction_closed": false
        },
        {
            "id": 20,
            "name": "LiveOnlineAuction League",
            "ownLeague": false,
            "package_id": 7,
            "introduction": "Live Online Auction League",
            "parent_division_id": null,
            "auction_types": "Live online",
            "auction_date": "2019-04-25 10:01:00",
            "pre_season_auction_budget": 200,
            "pre_season_auction_bid_increment": 1,
            "budget_rollover": "No",
            "seal_bids_budget": 500,
            "seal_bid_increment": "0.50",
            "seal_bid_minimum": 0,
            "manual_bid": "No",
            "first_seal_bid_deadline": "2019-04-25 10:00:00",
            "seal_bid_deadline_repeat": "everyMonth",
            "max_seal_bids_per_team_per_round": 5,
            "money_back": "none",
            "tie_preference": "lowerLeaguePositionWins",
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
            "allow_weekend_changes": "Yes",
            "enable_free_agent_transfer": "Yes",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "co_chairman_id": [
                10
            ],
            "co_chairman": [
                {
                    "id": 10,
                    "user_id": 10,
                    "dob": {
                        "date": "2003-08-26 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "address_1": "9074 Langworth Ville Apt. 656",
                    "address_2": "Dietrich Point",
                    "town": "Rudymouth",
                    "county": "Azerbaijan",
                    "post_code": "11857-4172",
                    "country": "Niue",
                    "telephone": "+1-724-526-2125",
                    "country_code": "+41",
                    "favourite_club": "Liverpool",
                    "introduction": "There's no pleasing them!' Alice was very nearly getting up and ran off, thinking while she was holding, and she put them into a tree. By the time she had drunk half the bottle, she found she could not.",
                    "has_games_news": false,
                    "has_fl_marketing": false,
                    "has_third_parities": false,
                    "user": {
                        "id": 10,
                        "first_name": "April",
                        "last_name": "Baumbach",
                        "email": "kaya.donnelly@example.org",
                        "username": null,
                        "status": "Active",
                        "last_login_at": null
                    }
                }
            ],
            "season_start": true,
            "package": {
                "id": 7,
                "name": "Pro 18/19",
                "display_name": "Pro",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "custom_squad_size": "No",
                "custom_club_quota": "No",
                "allow_custom_cup": "No",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "Yes"
            },
            "championLeague": 0,
            "europaLeague": 7,
            "europeanCups": true,
            "teams": [
                {
                    "id": 1,
                    "name": "Ben's Team"
                },
                {
                    "id": 2,
                    "name": "Richard's Team"
                },
                {
                    "id": 3,
                    "name": "Johan's Team"
                },
                {
                    "id": 4,
                    "name": "Stuart's Team"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": null,
            "auction_closing_date": null,
            "allow_passing_on_nominations": "No",
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_message": false,
            "auction_closed": false
        },
        {
            "id": 12,
            "name": "Lizeth",
            "ownLeague": false,
            "package_id": 5,
            "introduction": "A little bright-eyed terrier, you know, this sort in her French lesson-book. The Mouse gave a sudden burst of tears, until there was no 'One, two.",
            "parent_division_id": 11,
            "auction_types": "Online sealed bids",
            "auction_date": null,
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
            "merge_defenders": "Yes",
            "allow_weekend_changes": "No",
            "enable_free_agent_transfer": "No",
            "free_agent_transfer_authority": "chairman",
            "free_agent_transfer_after": "seasonStart",
            "season_free_agent_transfer_limit": 20,
            "monthly_free_agent_transfer_limit": 5,
            "co_chairman_id": [
                7
            ],
            "co_chairman": [
                {
                    "id": 7,
                    "user_id": 7,
                    "dob": {
                        "date": "1993-10-29 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "address_1": "6227 Thiel Ports",
                    "address_2": "Cremin Loaf",
                    "town": "Reynoldsberg",
                    "county": "Trinidad and Tobago",
                    "post_code": "90637-3479",
                    "country": "Palau",
                    "telephone": "(327) 946-2672 x78001",
                    "country_code": "+41",
                    "favourite_club": "Chelsea FC",
                    "introduction": "Alice! Come here directly, and get ready to sink into the jury-box, or they would go, and making faces at him as he spoke. 'A cat may look at it!' This speech caused a remarkable sensation among the trees, a little recovered from the.",
                    "has_games_news": true,
                    "has_fl_marketing": true,
                    "has_third_parities": true,
                    "user": {
                        "id": 7,
                        "first_name": "Clementine",
                        "last_name": "Ryan",
                        "email": "xdach@example.org",
                        "username": null,
                        "status": "Suspended",
                        "last_login_at": null
                    }
                }
            ],
            "season_start": true,
            "package": {
                "id": 5,
                "name": "Novice 18/19",
                "display_name": "Novice",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "custom_squad_size": "No",
                "custom_club_quota": "No",
                "allow_custom_cup": "Yes",
                "allow_fa_cup": "No",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "No"
            },
            "championLeague": 0,
            "europaLeague": 0,
            "europeanCups": true,
            "teams": [
                {
                    "id": 109,
                    "name": "Jessica Wolves"
                },
                {
                    "id": 110,
                    "name": "Ruth Fire Thunderballs"
                },
                {
                    "id": 111,
                    "name": "Ozella FC"
                },
                {
                    "id": 112,
                    "name": "Cara Royals"
                },
                {
                    "id": 113,
                    "name": "Kip Royals"
                },
                {
                    "id": 114,
                    "name": "Astrid Scintillating Assassins"
                },
                {
                    "id": 115,
                    "name": "Cortney Scoreless Hyenas"
                },
                {
                    "id": 116,
                    "name": "Ocie Hurricanes"
                },
                {
                    "id": 117,
                    "name": "Leda Devils"
                },
                {
                    "id": 118,
                    "name": "Virginie Knights"
                },
                {
                    "id": 119,
                    "name": "Cicero XI"
                },
                {
                    "id": 120,
                    "name": "Beverly Rockers"
                },
                {
                    "id": 121,
                    "name": "Kyra Slayers"
                },
                {
                    "id": 122,
                    "name": "Felipa Rag Gentlemen"
                },
                {
                    "id": 123,
                    "name": "Marcellus XI"
                },
                {
                    "id": 124,
                    "name": "Kareem Elephants"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": null,
            "auction_closing_date": null,
            "allow_passing_on_nominations": "No",
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": "No",
            "auction_message": false,
            "auction_closed": true
        },
        {
            "id": 14,
            "name": "Test",
            "ownLeague": true,
            "package_id": 1,
            "introduction": null,
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "auction_date": "2019-04-27 08:44:47",
            "pre_season_auction_budget": 390,
            "pre_season_auction_bid_increment": 7,
            "budget_rollover": "No",
            "seal_bids_budget": 67,
            "seal_bid_increment": "0.00",
            "seal_bid_minimum": 471,
            "manual_bid": "Yes",
            "first_seal_bid_deadline": "2019-03-13 13:17:26",
            "seal_bid_deadline_repeat": "everyWeek",
            "max_seal_bids_per_team_per_round": 1,
            "money_back": "fiftyPercent",
            "tie_preference": "randomlyAllocatedReverses",
            "rules": null,
            "default_squad_size": 17,
            "default_max_player_each_club": 1,
            "available_formations": [
                532,
                433
            ],
            "defensive_midfields": "No",
            "merge_defenders": "No",
            "allow_weekend_changes": "Yes",
            "enable_free_agent_transfer": "Yes",
            "free_agent_transfer_authority": "coChairman",
            "free_agent_transfer_after": "auctionEnd",
            "season_free_agent_transfer_limit": 710,
            "monthly_free_agent_transfer_limit": 750,
            "co_chairman_id": [
                1
            ],
            "co_chairman": [
                {
                    "id": 1,
                    "user_id": 1,
                    "dob": {
                        "date": "1986-10-05 00:00:00.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    },
                    "address_1": "6175 Makayla Turnpike Apt. 289",
                    "address_2": "Alia Route",
                    "town": "North Leviport",
                    "county": "Saudi Arabia",
                    "post_code": "71713",
                    "country": "Mozambique",
                    "telephone": "579-667-0965",
                    "country_code": "+41",
                    "favourite_club": "Chelsea FC",
                    "introduction": "Footman remarked, 'till.",
                    "has_games_news": true,
                    "has_fl_marketing": false,
                    "has_third_parities": false,
                    "user": {
                        "id": 1,
                        "first_name": "Ruchit",
                        "last_name": "Patel",
                        "email": "rpatel@aecordigital.com",
                        "username": null,
                        "status": "Active",
                        "last_login_at": {
                            "date": "2019-03-18 05:58:28.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        }
                    }
                }
            ],
            "season_start": true,
            "package": {
                "id": 1,
                "name": "Rusty Reynolds",
                "display_name": "Laverne Pfeffer",
                "short_description": "Dinah!' she said to herself 'Suppose it should be free of them hit her in a coaxing tone, and everybody laughed, 'Let the jury wrote it down into.",
                "long_description": "Bill's place for a good deal to come down the chimney close above her: then, saying to herself, being rather proud of it: 'No room! No room!' they cried out when they had settled down again, the.",
                "custom_squad_size": "Yes",
                "custom_club_quota": "Yes",
                "allow_custom_cup": "No",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "No",
                "allow_europa_league": "No",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "No"
            },
            "championLeague": 0,
            "europaLeague": 0,
            "europeanCups": true,
            "teams": [
                {
                    "id": 135,
                    "name": "Johan's Team"
                }
            ],
            "champions_league_team": null,
            "europa_league_team_1": null,
            "europa_league_team_2": null,
            "changeNotAllowed": true,
            "customCups": [],
            "auction_venue": "aecor",
            "auction_closing_date": null,
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null,
            "auction_message": true,
            "auction_closed": true
        }
    ]
}
```
