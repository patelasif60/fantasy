# Invitation API Docs

---

- [Get invite code for division](#invite_code_for_division)
- [Send Invitations](#send_invitations)
- [Get league details for invite code](#division_via_code)

<a name="invite_code_for_division"></a>
## Get invite code for division

This will provide the invitation code for the provided division.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/invite/managers/{division}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `11`


> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 37,
        "user_id": 10,
        "division_id": 11,
        "code": "C20AD4",
        "created_at": "2019-01-30 06:49:50",
        "updated_at": "2019-01-30 06:49:50"
    }
}
```
----
<a name="send_invitations"></a>
## Send Invitations

This will send league invitation email to all the provided emails.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/send/invitation/{division}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `11`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`invite_email_0`|`email`|`valid email required`|Ex: `demofl@email.com`
|`invite_email_1`|`email`|`valid email required`|Ex: `test1fl@email.com`
|`invite_email_2`|`email`|`valid email required`|Ex: `abcd@email.com`
|`.`|`email`|`valid email required`|Ex: `parkside@email.com`
|`.`|`email`|`valid email required`|Ex: `southfl@email.com`
|`.`|`email`|`valid email required`|Ex: `sundayfl@email.com`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "status": "true"
    }
}
```
----
<a name="division_via_code"></a>
## Get league details for invite code

Get the league details attached to the provided invite code.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/enter/code`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`invitation_code`|`string`|`required`|Ex: `CX204G`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 12,
        "name": "Demo1",
        "uuid": null,
        "chairman_id": 10,
        "package_id": 2,
        "introduction": "",
        "parent_division_id": 0,
        "auction_types": null,
        "auction_date": null,
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
        "custom_squad_size": null,
        "custom_club_quota": null,
        "available_formations": null,
        "defensive_midfields": null,
        "merge_defenders": null,
        "allow_weekend_changes": null,
        "enable_free_agent_transfer": null,
        "free_agent_transfer_authority": null,
        "free_agent_transfer_after": null,
        "season_free_agent_transfer_limit": null,
        "monthly_free_agent_transfer_limit": null,
        "created_at": "2019-01-30 06:49:48",
        "updated_at": "2019-01-30 06:49:48",
        "invite_code": {
            "id": 37,
            "user_id": 10,
            "division_id": 12,
            "code": "C20AD4",
            "created_at": "2019-01-30 06:49:50",
            "updated_at": "2019-01-30 06:49:50"
        },
        "consumer": {
            "id": 10,
            "user_id": 150,
            "dob": "2019-01-16 00:00:00",
            "address_1": null,
            "address_2": null,
            "town": null,
            "county": null,
            "post_code": null,
            "country": null,
            "telephone": null,
            "country_code": null,
            "favourite_club": null,
            "introduction": null,
            "has_games_news": false,
            "has_fl_marketing": null,
            "has_third_parities": false,
            "created_at": "2019-01-19 10:51:49",
            "updated_at": "2019-01-19 10:51:49",
            "user": {
                "id": 150,
                "first_name": "Farzan",
                "last_name": "Daudiya",
                "email": "farzan169@yahoo.com",
                "username": "farzan",
                "email_verified_at": null,
                "status": "Active",
                "last_login_at": "2019-01-22 11:50:39",
                "created_at": "2019-01-19 10:51:35",
                "updated_at": "2019-01-22 11:50:39",
                "provider": "email",
                "provider_id": null
            }
        }
    }
}
```