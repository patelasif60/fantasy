# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_edit"></a>
## League details

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{id}/settings`|`Bearer Token`|

### URL Params

```text
None
```
> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 24,
        "name": "Polly",
        "ownLeague": true,
        "introduction": "Hatter. He came in sight of the guinea-pigs cheered, and was just in time to see if there were TWO little shrieks, and more faintly came, carried on.",
        "package_id": 1,
        "parent_division_id": null,
        "auction_types": "Online",
        "auction_date": "2019-02-21 05:08:05",
        "pre_season_auction_budget": 100,
        "pre_season_auction_bid_increment": 1,
        "budget_rollover": "Yes",
        "seal_bids_budget": 25,
        "seal_bid_increment": "0.50",
        "seal_bid_minimum": 0,
        "manual_bid": "Yes",
        "first_seal_bid_deadline": "2019-02-21 05:08:05",
        "seal_bid_deadline_repeat": "everyFortnight",
        "max_seal_bids_per_team_per_round": 1,
        "money_back": "none",
        "tie_preference": "randomlyAllocated",
        "rules": null,
        "default_squad_size": 16,
        "default_max_player_each_club": 1,
        "available_formations": [
            "442",
            "451",
            "433",
            "532",
            "541"
        ],
        "defensive_midfields": "No",
        "merge_defenders": "No",
        "allow_weekend_changes": "Yes",
        "enable_free_agent_transfer": "Yes",
        "free_agent_transfer_authority": "all",
        "free_agent_transfer_after": "auctionEnd",
        "season_free_agent_transfer_limit": 100,
        "monthly_free_agent_transfer_limit": 10,
        "goal": null,
        "assist": null,
        "goal_conceded": null,
        "clean_sheet": null,
        "appearance": null,
        "club_win": null,
        "red_card": null,
        "yellow_card": null,
        "own_goal": null,
        "penalty_missed": null,
        "penalty_save": null,
        "goalkeeper_save_X5": null,
        "co_chairman_id": [],
        "co_chairman": [],
        "season_start": true,
        "package": {
            "id": 1,
            "name": "Legend 18/19",
            "display_name": "Legend",
            "short_description": "Lorem ipsum dolor sit amet",
            "long_description": "Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
            "custom_squad_size": "Yes",
            "custom_club_quota": "Yes",
            "allow_custom_cup": "Yes",
            "allow_fa_cup": "Yes",
            "allow_champion_league": "Yes",
            "allow_europa_league": "Yes",
            "allow_head_to_head": "Yes",
            "allow_linked_league": "Yes",
            "allow_custom_scoring": "Yes"
        },
        "divisionPoints": [
            {
                "id": 121,
                "division_id": 11,
                "events": "goal",
                "goal_keeper": 3,
                "centre_back": 3,
                "full_back": 3,
                "defensive_mid_fielder": 3,
                "mid_fielder": 3,
                "striker": 3
            },
            {
                "id": 122,
                "division_id": 11,
                "events": "assist",
                "goal_keeper": 2,
                "centre_back": 2,
                "full_back": 2,
                "defensive_mid_fielder": 2,
                "mid_fielder": 2,
                "striker": 2
            },
            {
                "id": 123,
                "division_id": 11,
                "events": "goal_conceded",
                "goal_keeper": -1,
                "centre_back": -1,
                "full_back": -1,
                "defensive_mid_fielder": -1,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 124,
                "division_id": 11,
                "events": "clean_sheet",
                "goal_keeper": 3,
                "centre_back": 3,
                "full_back": 3,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 125,
                "division_id": 11,
                "events": "appearance",
                "goal_keeper": 1,
                "centre_back": 1,
                "full_back": 1,
                "defensive_mid_fielder": 1,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 126,
                "division_id": 11,
                "events": "club_win",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 127,
                "division_id": 11,
                "events": "red_card",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 128,
                "division_id": 11,
                "events": "yellow_card",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 129,
                "division_id": 11,
                "events": "own_goal",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 130,
                "division_id": 11,
                "events": "penalty_missed",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 131,
                "division_id": 11,
                "events": "penalty_save",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            },
            {
                "id": 132,
                "division_id": 11,
                "events": "goalkeeper_save_x5",
                "goal_keeper": 0,
                "centre_back": 0,
                "full_back": 0,
                "defensive_mid_fielder": 0,
                "mid_fielder": 0,
                "striker": 0
            }
        ]
    },
    "consumers": [
        {
            "id": 1,
            "user_id": 6,
            "dob": {
                "date": "1978-03-31 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "address_1": "607 Brent Falls",
            "address_2": "Welch Circle",
            "town": "Marcellusside",
            "county": "Burkina Faso",
            "post_code": "91410",
            "country": "Tunisia",
            "telephone": "658-966-5640",
            "country_code": "+41",
            "favourite_club": "Liverpool",
            "introduction": "Majesty!' the Duchess to play croquet.' Then they both cried. 'Wake up, Alice dear!' said her sister; 'Why, what are YOUR shoes done with?' said the Mock Turtle in the distance, and.",
            "has_games_news": false,
            "has_fl_marketing": false,
            "has_third_parities": false,
            "user": {
                "id": 6,
                "first_name": "Ruchit",
                "last_name": "Patel",
                "email": "rpatel@aecordigital.com",
                "username": null,
                "status": "Active",
                "last_login_at": null
            }
        },
        {
            "id": 2,
            "user_id": 7,
            "dob": {
                "date": "1998-03-04 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "address_1": "5374 Yost Overpass",
            "address_2": "Glover Throughway",
            "town": "South Deantown",
            "county": "Hong Kong",
            "post_code": "71245",
            "country": "Portugal",
            "telephone": "+1-352-840-1228",
            "country_code": "+41",
            "favourite_club": "Arsenal",
            "introduction": "The Queen had never left off staring at the place where it had grown to her ear. 'You're thinking about something, my dear, and that you had been broken to pieces.",
            "has_games_news": false,
            "has_fl_marketing": true,
            "has_third_parities": true,
            "user": {
                "id": 7,
                "first_name": "Nirav",
                "last_name": "Patel",
                "email": "npatel@aecordigital.com",
                "username": null,
                "status": "Suspended",
                "last_login_at": null
            }
        },
        {
            "id": 3,
            "user_id": 8,
            "dob": {
                "date": "1972-07-31 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "address_1": "96836 Bailey Fork",
            "address_2": "Rosario Square",
            "town": "New Averyview",
            "county": "Peru",
            "post_code": "59189",
            "country": "Portugal",
            "telephone": "754.803.1288 x56528",
            "country_code": "+41",
            "favourite_club": "Chelsea FC",
            "introduction": "I try the experiment?' 'HE might bite,' Alice cautiously replied: 'but I must have been was not a regular rule: you invented it just now.' 'It's the Cheshire Cat, she was terribly frightened all the other queer noises, would change to tinkling sheep-bells, and the three gardeners, but she could.",
            "has_games_news": true,
            "has_fl_marketing": true,
            "has_third_parities": false,
            "user": {
                "id": 8,
                "first_name": "Mya",
                "last_name": "Hilpert",
                "email": "feeney.ramiro@example.org",
                "username": null,
                "status": "Active",
                "last_login_at": null
            }
        },
        ...
    ],
    "divisions": {
        "1": "Chadd",
        "2": "Filomena",
        "3": "Jannie",
        "4": "Myrtis",
        "5": "Ella",
        "7": "Brock",
        "9": "Cecelia",
        "12": "league145",
        "13": "18FebLeague",
        "14": "18FebLeague1",
        "15": "18FebLeague2",
        "16": "18FebLeague3",
        "17": "18FebLeague4",
        "18": "Championship 2",
        "19": "Aecor 2019",
        "20": "Aecor 2018",
        "21": "Test",
        "22": "League",
        "23": "League iphone",
        "24": "My League 1",
        "25": "My League 2",
        "26": "19FebLeague",
        "27": "19FebLeague2",
        "28": "20th Feb",
        "29": "21FebLeague"
    },
    "yesNo": {
        "Yes": "Yes",
        "No": "No"
    },
    "auctionTypesEnum": {
        "Live": "Live",
        "Online": "Online"
    },
    "sealedBidDeadLinesEnum": {
        "dontRepeat": "Don’t repeat",
        "everyMonth": "Every month",
        "everyFortnight": "Every fortnight",
        "everyWeek": "Every week"
    },
    "moneyBackEnum": {
        "none": "None",
        "hunderedPercent": "100% of original auction price",
        "fiftyPercent": "50% of original auction price"
    },
    "tiePreferenceEnum": {
        "no": "No tie preference",
        "earliestBidWins": "Earliest bid wins",
        "lowerLeaguePositionWins": "Lower league position wins",
        "higherLeaguePositionWins": "Higher league position wins",
        "randomlyAllocated": "Randomly allocated",
        "randomlyAllocatedReverses": "Randomly allocated, then reverses each round"
    },
    "formation": {
        "433": "4-3-3",
        "442": "4-4-2",
        "451": "4-5-1",
        "532": "5-3-2",
        "541": "5-4-1"
    },
    "transferAuthority": {
        "chairman": "Chairman",
        "coChairman": "Co-Chairman",
        "all": "All"
    },
    "agentTransferAfterEnum": {
        "auctionEnd": "Auction end",
        "seasonStart": "Season start"
    },
    "digitalPrizeTypeEnum": {
        "Standard": "Standard",
        "Basic": "Basic"
    },
    "onlyNoEnum": "No",
    "championLeague": 9,
    "europaLeague": 0
}
```
