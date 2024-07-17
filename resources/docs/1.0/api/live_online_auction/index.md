# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Online Auction Start](#online_auction_start)
- [Search Player](#search_player)
- [Get players by club name or position](#get_all_players)
- [Sold player](#sold_player)
- [Update Sold Player Bid](#update_sold_player)
- [Delete Sold Player Bid](#delete_sold_player)
- [Get Sold Players For Team](#team_sold_players)
- [Get Server Current Timestamp](#server_timestamp)
- [End Auction](#end_auction)
- [Check Auction Status](#check_auction_status)

<a name="online_auction_start"></a>
## Online Auction Start

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/lonauction/start`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "division": {
            "id": 70,
            "name": "Aecor space",
            "uuid": "121e86a2-6314-4731-8a15-c4af45570246",
            "chairman_id": 85,
            "package_id": 8,
            "prize_pack": null,
            "introduction": "",
            "parent_division_id": null,
            "auction_types": "Live online",
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null,
            "auction_date": "2019-05-01 13:53:16",
            "pre_season_auction_budget": 200,
            "pre_season_auction_bid_increment": 1,
            "budget_rollover": "No",
            "seal_bids_budget": null,
            "seal_bid_increment": null,
            "seal_bid_minimum": null,
            "manual_bid": "No",
            "first_seal_bid_deadline": null,
            "seal_bid_deadline_repeat": null,
            "max_seal_bids_per_team_per_round": null,
            "money_back": null,
            "tie_preference": "earliestBidWins",
            "rules": null,
            "default_squad_size": 15,
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
            "created_at": "2019-05-21 09:03:57",
            "updated_at": "2019-06-25 11:09:02",
            "auction_venue": null,
            "auctioneer_id": null,
            "auction_closing_date": null,
            "is_round_process": false,
            "is_viewed_package_selection": 1,
            "package": {
                "id": 8,
                "is_enabled": "Yes",
                "name": "Legend 18/19",
                "display_name": "Legend",
                "short_description": "Lorem ipsum dolor sit amet",
                "long_description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia tortor et magna euismod hendrerit. Nam vitae lorem massa. Curabitur egestas purus maximus dolor tincidunt rutrum. In nisi neque, hendrerit nec nisl a, gravida semper ante. Sed quis eleifend felis, quis tristique ipsum. Aenean nunc tellus, dictum quis vestibulum ornare, vehicula sed massa.",
                "prize_packs": null,
                "available_new_user": "No",
                "price": "30.00",
                "private_league": "Yes",
                "minimum_teams": 5,
                "maximum_teams": 5,
                "auction_types": [
                    "Live offline",
                    "Online sealed bids",
                    "Live online"
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
                "custom_squad_size": "Yes",
                "default_squad_size": 15,
                "custom_club_quota": "Yes",
                "default_max_player_each_club": 3,
                "available_formations": [
                    "442",
                    "451",
                    "433",
                    "532",
                    "541"
                ],
                "defensive_midfields": "No",
                "merge_defenders": "No",
                "enable_free_agent_transfer": "Yes",
                "free_agent_transfer_authority": "chairman",
                "free_agent_transfer_after": "seasonStart",
                "season_free_agent_transfer_limit": 20,
                "monthly_free_agent_transfer_limit": 5,
                "allow_weekend_changes": "Yes",
                "allow_custom_cup": "Yes",
                "allow_fa_cup": "Yes",
                "allow_champion_league": "Yes",
                "allow_europa_league": "Yes",
                "allow_pro_cup": "Yes",
                "allow_head_to_head": "Yes",
                "allow_linked_league": "Yes",
                "digital_prize_type": "Basic",
                "allow_custom_scoring": "Yes",
                "max_free_places": 2,
                "enable_supersubs": "Yes",
                "badge_color": "gold",
                "allow_auction_budget": null,
                "allow_bid_increment": null,
                "allow_process_bids": null,
                "allow_defensive_midfielders": null,
                "allow_merge_defenders": null,
                "allow_weekend_changes_editable": null,
                "allow_rollover_budget": null,
                "allow_available_formations": null,
                "allow_supersubs": null,
                "allow_seal_bid_deadline_repeat": null,
                "allow_season_free_agent_transfer_limit": null,
                "allow_monthly_free_agent_transfer_limit": null,
                "allow_free_agent_transfer_authority": null,
                "created_at": "2019-03-13 13:17:26",
                "updated_at": "2019-06-17 07:01:11",
                "package_points": [
                    {
                        "id": 64,
                        "package_id": 8,
                        "events": "goal",
                        "goal_keeper": 3,
                        "centre_back": 3,
                        "full_back": 3,
                        "defensive_mid_fielder": 3,
                        "mid_fielder": 3,
                        "striker": 3,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-06-17 07:01:11"
                    },
                    {
                        "id": 65,
                        "package_id": 8,
                        "events": "assist",
                        "goal_keeper": 2,
                        "centre_back": 2,
                        "full_back": 2,
                        "defensive_mid_fielder": 2,
                        "mid_fielder": 2,
                        "striker": 2,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-06-17 07:01:11"
                    },
                    {
                        "id": 66,
                        "package_id": 8,
                        "events": "goal_conceded",
                        "goal_keeper": -1,
                        "centre_back": -1,
                        "full_back": -1,
                        "defensive_mid_fielder": 0,
                        "mid_fielder": 0,
                        "striker": 0,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-06-17 07:01:11"
                    },
                    {
                        "id": 67,
                        "package_id": 8,
                        "events": "clean_sheet",
                        "goal_keeper": 2,
                        "centre_back": 2,
                        "full_back": 2,
                        "defensive_mid_fielder": 2,
                        "mid_fielder": 0,
                        "striker": 0,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-06-17 07:01:11"
                    },
                    {
                        "id": 68,
                        "package_id": 8,
                        "events": "appearance",
                        "goal_keeper": 1,
                        "centre_back": 1,
                        "full_back": 1,
                        "defensive_mid_fielder": 0,
                        "mid_fielder": 0,
                        "striker": 0,
                        "created_at": "2019-03-13 13:17:26",
                        "updated_at": "2019-06-17 07:01:11"
                    }
                ]
            },
            "division_teams": [
                {
                    "id": 209,
                    "name": "Ashish's Team",
                    "manager_id": 85,
                    "crest_id": 4,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_ignored": false,
                    "uuid": "c5f85acb-f3a6-4771-94bf-50f652d25c44",
                    "team_budget": "84.00",
                    "created_at": "2019-05-21 09:04:02",
                    "updated_at": "2019-06-27 07:05:37",
                    "pivot": {
                        "division_id": 70,
                        "team_id": 209,
                        "payment_id": 22,
                        "season_id": 19
                    }
                },
                {
                    "id": 210,
                    "name": "Johan's Team",
                    "manager_id": 35,
                    "crest_id": 4,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_ignored": false,
                    "uuid": "247e02b7-e12a-4573-b20e-09a342babd72",
                    "team_budget": "82.00",
                    "created_at": "2019-05-21 09:04:29",
                    "updated_at": "2019-06-27 07:05:37",
                    "pivot": {
                        "division_id": 70,
                        "team_id": 210,
                        "payment_id": 22,
                        "season_id": 19
                    }
                }
            ]
        },
        "teamManagers": [
            {
                "team_id": 209,
                "team_name": "Ashish's Team",
                "manager_id": 85,
                "crest_id": 4,
                "team_budget": 84,
                "first_name": "Ashish",
                "last_name": "Parmar",
                "email": "aparmar+fl1@aecordigital.com",
                "id": 0,
                "is_remote": 0,
                "order": 0,
                "team_crest": "https://fantasyleague-qa.s3.amazonaws.com/4/conversions/2ee6a052cd140814c6ef69739886b198-thumb.jpg"
            },
            {
                "team_id": 210,
                "team_name": "Johan's Team",
                "manager_id": 35,
                "crest_id": 4,
                "team_budget": 82,
                "first_name": "Johan",
                "last_name": "Haynes",
                "email": "jhaynes+fl1@aecordigital.com",
                "id": 1,
                "is_remote": 0,
                "order": 1,
                "team_crest": "https://fantasyleague-qa.s3.amazonaws.com/4/conversions/2ee6a052cd140814c6ef69739886b198-thumb.jpg"
            }
        ],
        "positions": {
            "Goalkeeper (GK)": "Goalkeeper",
            "Full-back (FB)": "Fullback",
            "Centre-back (CB)": "Centreback",
            "Midfielder (MF)": "Midfielder",
            "Striker (ST)": "Striker"
        },
        "clubs": {
            "1": "AFC Bournemouth",
            "2": "Arsenal",
            "3": "Brighton & Hove Albion",
            "4": "Burnley",
            "5": "Cardiff City",
            "6": "Chelsea",
            "7": "Crystal Palace",
            "8": "Everton",
            "9": "Fulham",
            "10": "Huddersfield Town",
            "11": "Leicester City",
            "12": "Liverpool",
            "13": "Manchester City",
            "14": "Manchester United",
            "15": "Newcastle United",
            "16": "Southampton",
            "17": "Tottenham Hotspur",
            "18": "Watford",
            "19": "West Ham United",
            "20": "Wolverhampton Wanderers",
            "21": "Millwall FC",
            "22": "Swansea City AFC",
            "23": "Doncaster Rovers FC",
            "24": "Bristol City FC",
            "25": "Newport County AFC",
            "26": "Derby County FC",
            "27": "Queens Park Rangers FC",
            "28": "West Bromwich Albion FC",
            "29": "Shrewsbury Town FC",
            "30": "Sheffield Wednesday FC",
            "31": "AFC Wimbledon",
            "32": "Shrewsbury Town FC",
            "33": "Derby County FC",
            "34": "Blackburn Rovers FC",
            "35": "Woking FC",
            "36": "Rotherham United FC",
            "37": "Oldham Athletic AFC",
            "38": "Grimsby Town FC",
            "39": "Blackpool FC",
            "40": "Nottingham Forest FC",
            "41": "Derby County FC",
            "42": "Lincoln City FC",
            "43": "Gillingham FC",
            "44": "Reading FC",
            "45": "Barnsley FC",
            "46": "Birmingham City FC",
            "47": "Tranmere Rovers FC"
        },
        "players": [
            {
                "id": 4,
                "player_first_name": "Tyrone",
                "player_last_name": "Mings",
                "club_id": 1,
                "club_name": "AFC Bournemouth",
                "shortCode": "BOR",
                "position": "GK",
                "team_id": null,
                "team_name": null,
                "user_first_name": null,
                "user_last_name": null,
                "short_code": "BOR",
                "team_player_contract_id": null,
                "total_goal": null,
                "total_assist": null,
                "total_goal_against": null,
                "total_clean_sheet": null,
                "total_game_played": 0,
                "nextFixture": "",
                "total": 0
            },
            {
                "id": 8,
                "player_first_name": "Asmir",
                "player_last_name": "Begovic",
                "club_id": 1,
                "club_name": "AFC Bournemouth",
                "shortCode": "BOR",
                "position": "GK",
                "team_id": 210,
                "team_name": "Johan's Team",
                "user_first_name": "Johan",
                "user_last_name": "Haynes",
                "short_code": "BOR",
                "team_player_contract_id": 3607,
                "total_goal": null,
                "total_assist": null,
                "total_goal_against": null,
                "total_clean_sheet": null,
                "total_game_played": 0,
                "nextFixture": "",
                "total": 0
            },
            ...
        ],
        "maxClubPlayer": 3,
        "defaultSquadSize": 15,
        "currentDateTime": "2019-06-28 09:48:21",
        "teamDetails": {
            "id": 209,
            "name": "Ashish's Team",
            "manager_id": 85,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "is_ignored": false,
            "uuid": "c5f85acb-f3a6-4771-94bf-50f652d25c44",
            "team_budget": "84.00",
            "created_at": "2019-05-21 09:04:02",
            "updated_at": "2019-06-27 07:05:37",
            "pivot": {
                "division_id": 70,
                "team_id": 209,
                "payment_id": 22,
                "season_id": 19
            }
        }
    }
}
```
---

<a name="search_player"></a>
## Search Player

This will return all players which are unsold. Sold players will not be returned in ajax call.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/lonauction`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`player`|`string`|`required`|Ex: `Alexandre`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "68": {
            "id": 68,
            "first_name": "Alexandre",
            "last_name": "Lacazette",
            "psc": "652",
            "club_short_code": "ARS",
            "position": "ST",
            "club_name": "Arsenal",
            "club_id": 2,
            "display_name": "Alexandre Lacazette (ARS) ST"
        }
    }
}
```

---

<a name="get_all_players"></a>
## Get Players by club name or position

This will return all players.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/lonauction`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`position`|`string`|`required`|Ex: `Centre-back (CB)`
|`club`|`integer`|`optional`|Ex: 3

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": [
        {
            "id": 77,
            "player_first_name": "Leo",
            "player_last_name": "Skiri Oestigaard",
            "club_id": 3,
            "club_name": "Brighton & Hove Albion",
            "shortCode": "BRI",
            "position": "CB",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "short_code": "BRI",
            "team_player_contract_id": null,
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": 0,
            "nextFixture": "",
            "total": 0,
            "available": true,
            "club_quota": ""
        },
        {
            "id": 79,
            "player_first_name": "Markus",
            "player_last_name": "Suttner",
            "club_id": 3,
            "club_name": "Brighton & Hove Albion",
            "shortCode": "BRI",
            "position": "CB",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "short_code": "BRI",
            "team_player_contract_id": null,
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": 0,
            "nextFixture": "",
            "total": 0,
            "available": true,
            "club_quota": ""
        },
        ...
    ]
}
```

---

<a name="sold_player"></a>
## Sold Player

This will call when round has been finished and player has been sold to highes bidder.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/player/sold`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`club_id`|`integer`|`required`|Ex: 2
|`team_id`|`integer`|`required`|Ex: 209
|`player_id`|`integer`|`required`|Ex: 68
|`opening_bid_manager_id`|`integer`|`required`|Ex: 85
|`opening_bid`|`decimal`|`required`|Ex: 2 or 2.55 (max 2 decimal points)
|`high_bidder_id`|`integer`|`required`|Ex: 85
|`high_bid_value`|`decimal`|`required`|Ex: 2 or 2.55 (max 2 decimal points)
|`position`|`string`|`required`|Ex: `ST`
|`round`|`integer`|`required`|Ex: 1

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "success": true
    }
}

{
    "status": "success",
    "data": {
        "success": false,
        "message": "Invalid formation"
    }
}
```

---

<a name="update_sold_player"></a>
## Update Sold Player

This will use to update sold player bid only by Auctioneer.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/update/sold/player`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`club_id`|`integer`|`required`|Ex: 2
|`team_id`|`integer`|`required`|Ex: 209
|`player_id`|`integer`|`required`|Ex: 68
|`bidder_id`|`integer`|`required`|Ex: 85
|`bid_price`|`decimal`|`required`|Ex: 2 or 2.55 (max 2 decimal points)
|`position`|`string`|`required`|Ex: `ST`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "success": true
    }
}

{
    "status": "success",
    "data": {
        "success": false,
        "message": "Invalid formation"
    }
}
```

---

<a name="delete_sold_player"></a>
## Delete Sold Player

This will use to cancel sold player bid only by Auctioneer.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/delete/sold/player`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`club_id`|`integer`|`required`|Ex: 2
|`team_id`|`integer`|`required`|Ex: 209
|`player_id`|`integer`|`required`|Ex: 68
|`bidder_id`|`integer`|`required`|Ex: 85
|`position`|`string`|`required`|Ex: `ST`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "success": true
    }
}
```

---

<a name="team_sold_players"></a>
## Sold Players For Team

This will return all players which are won by a team

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/sold/player/team/{team}`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`
|`team`|`integer`|`required`|Ex: `209`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "mf": [
            {
                "id": 5,
                "division_id": 70,
                "season_id": 19,
                "team_id": 209,
                "player_id": 468,
                "position": "MF",
                "round": 1,
                "club_id": 14,
                "high_bidder_id": 85,
                "high_bid": "5.00",
                "opening_bidder_id": 85,
                "opening_bid": "5.00",
                "created_at": "2019-06-27 13:32:35",
                "updated_at": "2019-06-27 13:32:35",
                "name": "AFC Bournemouth",
                "api_id": "1pse9ta7a45pi2w2grjim70ge",
                "short_name": "Bournemouth",
                "short_code": "BOU",
                "is_premier": 1,
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOU/player.png"
            }
        ],
        "cb": [
            {
                "id": 6,
                "division_id": 70,
                "season_id": 19,
                "team_id": 209,
                "player_id": 25,
                "position": "CB",
                "round": 1,
                "club_id": 1,
                "high_bidder_id": 85,
                "high_bid": "5.00",
                "opening_bidder_id": 85,
                "opening_bid": "5.00",
                "created_at": "2019-06-27 13:37:34",
                "updated_at": "2019-06-27 13:37:34",
                "name": "AFC Bournemouth",
                "api_id": "1pse9ta7a45pi2w2grjim70ge",
                "short_name": "Bournemouth",
                "short_code": "BOU",
                "is_premier": 1,
                "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BOU/player.png"
            }
        ]
    }
}
```

---

<a name="server_timestamp"></a>
## Server Current Timestamp

This will return server's current timestamp which will be used for timer.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/get/server_time`|`Bearer Token`|


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "timestamp": 1561642979
    }
}
```

---

<a name="end_auction"></a>
## Online Auction End

This will use when all teams are full with players and Auctioneer clicks on end auction button.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/end/{division}/lonauction`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been updated successfully."
}

{
    "status": "error",
    "message": "Invalid request"
}
```

---

<a name="check_auction_status"></a>
## Check Auction Status

This will use to check auction status. If it returns true then auction is closed.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/check/{division}/lon/isclosed`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `70`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "isClosed": false
    }
}
```