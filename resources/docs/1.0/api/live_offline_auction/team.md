# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_list"></a>
##Team Player List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/team/{team}/auction`|`Bearer Token`|


### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
{
  "status": "success",
  "data": {
    "team": {
      "id": 1617,
      "name": "The Moura, The Merrier",
      "manager_id": 6,
      "crest_id": 18,
      "pitch_id": null,
      "is_approved": true,
      "is_ignored": false,
      "uuid": "cb103b0c-7fef-4c9f-9ad4-70808c1cb64d",
      "team_budget": "7.80",
      "is_legacy": 1,
      "season_quota_used": 7,
      "monthly_quota_used": 3,
      "created_at": "2019-07-09 13:33:49",
      "updated_at": "2019-11-15 15:35:38",
      "crest": "https://fantasyleague-qa.s3.amazonaws.com/1059/conversions/FL_Team-Badge-Icons_AW-39-thumb-thumb.png",
      "team_players_count": 15,
      "defaultSquadSize": 15,
      "team_division": [
        {
          "id": 223,
          "name": "Banbury Boys Get Up Hurley In The Morning",
          "uuid": "5c9ce3a7-d6c8-45f3-8c54-07546fece790",
          "chairman_id": 6,
          "package_id": 8,
          "prize_pack": 5,
          "introduction": null,
          "parent_division_id": null,
          "auction_types": "Live offline",
          "allow_passing_on_nominations": null,
          "remote_nomination_time_limit": null,
          "remote_bidding_time_limit": null,
          "allow_managers_to_enter_own_bids": "No",
          "auction_date": "2019-08-04 11:00:00",
          "pre_season_auction_budget": 40,
          "pre_season_auction_bid_increment": "0.10",
          "budget_rollover": "Yes",
          "seal_bids_budget": 0,
          "seal_bid_increment": "0.10",
          "seal_bid_minimum": "0.00",
          "manual_bid": null,
          "first_seal_bid_deadline": "2019-07-10 03:22:15",
          "seal_bid_deadline_repeat": "everyWeek",
          "max_seal_bids_per_team_per_round": 5,
          "money_back": "fiftyPercent",
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
          "defensive_midfields": "No",
          "merge_defenders": "No",
          "allow_weekend_changes": "No",
          "enable_free_agent_transfer": "Yes",
          "free_agent_transfer_authority": "chairman",
          "free_agent_transfer_after": "seasonStart",
          "season_free_agent_transfer_limit": 15,
          "monthly_free_agent_transfer_limit": 5,
          "champions_league_team": 1614,
          "europa_league_team_1": 1615,
          "europa_league_team_2": 1617,
          "created_at": "2019-07-09 13:09:12",
          "updated_at": "2019-11-15 15:33:24",
          "auction_venue": "Elephant & Castle, Bloxham",
          "auctioneer_id": 6,
          "auction_closing_date": null,
          "is_round_process": false,
          "is_viewed_package_selection": 1,
          "is_legacy": 1,
          "pivot": {
            "team_id": 1617,
            "division_id": 223
          }
        }
      ]
    },
    "teamClubsPlayer": {
      "2": 1,
      "3": 1,
      "4": 1,
      "6": 2,
      "8": 1,
      "11": 2,
      "13": 1,
      "14": 2,
      "15": 1,
      "16": 1,
      "17": 2
    },
    "maxClubPlayers": 2,
    "mergeDefenders": "No",
    "defensiveMidfields": "No",
    "availablePostions": [],
    "clubs": [
      {
        "id": 2,
        "name": "Arsenal",
        "short_code": "ARS",
        "active_players": [
          {
            "id": 36,
            "first_name": "Denis",
            "last_name": "Suarez",
            "match_name": "D. Suarez",
            "short_code": null,
            "api_id": "28psc296gj3umo59qqha8jil1",
            "created_at": "2019-07-09 12:12:29",
            "updated_at": "2019-07-10 06:12:37",
            "contract": {
              "club_id": 2,
              "player_id": 36,
              "id": 36,
              "position": "Midfielder (MF)",
              "is_active": 0,
              "start_date": "2018-08-30",
              "end_date": null,
              "created_at": "2019-07-09 12:12:29",
              "updated_at": "2019-07-10 05:50:33"
            }
          }
        ]
      }
    ],
    "positions": {
      "GK": "Goalkeeper",
      "FB": "Fullback",
      "CB": "Centreback",
      "MF": "Midfielder",
      "ST": "Striker"
    },
    "players": {
      "GK": [
        {
          "team_id": 1617,
          "player_id": 470,
          "team_name": "The Moura, The Merrier",
          "player_first_name": "David",
          "player_last_name": "de Gea",
          "short_code": "MU",
          "position": "GK",
          "club_name": "Manchester United",
          "club_id": 14,
          "transfer_value": "3.80",
          "total_points": "0",
          "team_player_contract_id": 53037,
          "nextFixture": "2019-12-01 16:30:00",
          "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/MU/GK.png"
        }
      ],
      "FB": [
        {
          "team_id": 1617,
          "player_id": 58,
          "team_name": "The Moura, The Merrier",
          "player_first_name": "Nacho",
          "player_last_name": "Monreal",
          "short_code": "ARS",
          "position": "FB",
          "club_name": "Arsenal",
          "club_id": 2,
          "transfer_value": "0.10",
          "total_points": "1",
          "team_player_contract_id": 53040,
          "nextFixture": "2019-12-01 14:00:00",
          "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/ARS/player.png"
        }
      ],
      "CB": [
        {
          "team_id": 1617,
          "player_id": 177,
          "team_name": "The Moura, The Merrier",
          "player_first_name": "David",
          "player_last_name": "Luiz",
          "short_code": "CHE",
          "position": "CB",
          "club_name": "Chelsea",
          "club_id": 6,
          "transfer_value": "6.40",
          "total_points": "3",
          "team_player_contract_id": 53043,
          "nextFixture": "2019-11-30 15:00:00",
          "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/CHE/player.png"
        }
      ],
      "MF": [
        {
          "team_id": 1617,
          "player_id": 76,
          "team_name": "The Moura, The Merrier",
          "player_first_name": "Pascal",
          "player_last_name": "Gross",
          "short_code": "BHA",
          "position": "MF",
          "club_name": "Brighton & Hove Albion",
          "club_id": 3,
          "transfer_value": "0.10",
          "total_points": "3",
          "team_player_contract_id": 53061,
          "nextFixture": "2019-11-30 15:00:00",
          "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BHA/player.png"
        }
      ],
      "ST": [
        {
          "team_id": 1617,
          "player_id": 133,
          "team_name": "The Moura, The Merrier",
          "player_first_name": "Chris",
          "player_last_name": "Wood",
          "short_code": "BUR",
          "position": "ST",
          "club_name": "Burnley",
          "club_id": 4,
          "transfer_value": "0.10",
          "total_points": "11",
          "team_player_contract_id": 479281,
          "nextFixture": "2019-11-30 15:00:00",
          "tshirt": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/BUR/player.png"
        }
      ]
    }
  }
}
```
