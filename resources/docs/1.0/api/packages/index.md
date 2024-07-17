# Packages API Docs

---

- [Packages list](#packages_list)
- [Package description](#packages_description)

<a name="packages_list"></a>
## Packages List

This will list out all the available packages in system.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/package/selection`|`Bearer Token`|

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
            "id": 1,
            "name": "Startup",
            "short_description": "William the Conqueror.' (For, with all their simple joys, remembering her own ears for having cheated herself in a great crash, as if it makes me."
        },
        {
            "id": 2,
            "name": "Intermediate",
            "short_description": "Alice. It looked good-natured, she thought: still it was addressed to the table, but there were any tears. No, there were ten of them, and all."
        },
        {
            "id": 3,
            "name": "Expert",
            "short_description": "King, 'and don't look at all a proper way of settling all difficulties, great or small. 'Off with her head!' Alice glanced rather anxiously at the."
        },
        {
            "id": 4,
            "name": "Professional",
            "short_description": "Queen's ears--' the Rabbit came up to the table to measure herself by it, and very soon came upon a little ledge of rock, and, as the White Rabbit."
        }
    ]
}
```
----
<a name="packages_description"></a>
## Package description

This will provide all the details of a specified package.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/package/description/{package}`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`package`|`integer`|`required`|Ex: `29`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 1,
        "is_enabled": "Yes",
        "name": "Mrs. Janet Dach",
        "display_name": "Darron Watsica",
        "short_description": "William the Conqueror.' (For, with all their simple joys, remembering her own ears for having cheated herself in a great crash, as if it makes me.",
        "long_description": "AND WASHING--extra.\"' 'You couldn't have done that, you know,' said Alice, rather doubtfully, as she had plenty of time as she couldn't answer either question, it didn't much matter which way you.",
        "available_new_user": "Yes",
        "price": "27.00",
        "private_league": "Yes",
        "minimum_teams": 3,
        "auction_types": "Live",
        "pre_season_auction_budget": 180,
        "pre_season_auction_bid_increment": 3,
        "budget_rollover": "No",
        "seal_bids_budget": 51,
        "seal_bid_increment": "4.00",
        "seal_bid_minimum": 850,
        "manual_bid": "No",
        "first_seal_bid_deadline": "29/01/2019 12:55:10",
        "seal_bid_deadline_repeat": "everyWeek",
        "max_seal_bids_per_team_per_round": 1,
        "money_back": "fiftyPercent",
        "tie_preference": "higherLeaguePositionWins",
        "custom_squad_size": "Yes",
        "default_squad_size": 18,
        "custom_club_quota": "Yes",
        "default_max_player_each_club": 1,
        "available_formations": [
            433,
            541,
            451,
            532,
            442
        ],
        "defensive_midfields": "No",
        "merge_defenders": "No",
        "enable_free_agent_transfer": "No",
        "free_agent_transfer_authority": "chairman",
        "free_agent_transfer_after": "seasonStart",
        "season_free_agent_transfer_limit": 364,
        "monthly_free_agent_transfer_limit": 856,
        "allow_weekend_changes": "No",
        "allow_custom_cup": "Yes",
        "allow_fa_cup": "No",
        "allow_champion_league": "Yes",
        "allow_europa_league": "Yes",
        "allow_head_to_head": "Yes",
        "allow_linked_league": "No",
        "digital_prize_type": "Standard",
        "allow_custom_scoring": "Yes",
        "created_at": "2019-01-29 12:55:10",
        "updated_at": "2019-01-29 12:55:10"
    }
}
```
