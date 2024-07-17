# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="login"></a>
## Login

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/login`|Default|

### URL Params

```text
None
```

### Data Params

```json
{
    "email"    : "example@example.com",
    "password"     : "password",
}
```

|Params|Type|Values|Example|
|:-|:-|:-|
|`email`|String|`required`|Ex:`example@example.com`|
|`email`|String|`required`|Ex:`password`|


> {success} Success Response

Code `200`

Content

```json
{
    "user": {
        "id": 52,
        "first_name": "Matt",
        "last_name": "Sims",
        "email": "matts@fantasyleague.com",
        "username": "msims",
        "email_verified_at": "2019-03-13 13:17:25",
        "status": "Active",
        "last_login_at": "2019-05-31 08:05:58",
        "provider": "email",
        "provider_id": null,
        "remember_url": null,
        "push_registration_id": null,
        "created_at": "2019-03-13 13:17:25",
        "updated_at": "2019-05-31 08:05:58",
        "roles": [
            {
                "id": 3,
                "name": "user",
                "guard_name": "web",
                "created_at": "2019-03-13 13:17:24",
                "updated_at": "2019-03-13 13:17:24",
                "pivot": {
                    "model_id": 52,
                    "role_id": 3,
                    "model_type": "App\\Models\\User"
                }
            }
        ],
        "consumer": {
            "id": 37,
            "user_id": 52,
            "dob": "1974-12-16 00:00:00",
            "address_1": "4a Manland Avenue",
            "address_2": null,
            "town": "Harpenden",
            "county": null,
            "post_code": "AL5 4RF",
            "country": "UK",
            "telephone": null,
            "country_code": "+44",
            "favourite_club": "Tottenham Hotspur",
            "introduction": null,
            "has_games_news": true,
            "has_fl_marketing": false,
            "has_third_parities": false,
            "created_at": "2019-03-13 13:17:25",
            "updated_at": "2019-05-28 11:09:57"
        }
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjAuMTgxOjgwMDBcL2FwaVwvbG9naW4iLCJpYXQiOjE1NTkyOTA4MDcsImV4cCI6MTU1OTMzNDAwNywibmJmIjoxNTU5MjkwODA3LCJqdGkiOiI3TWo2VnJWeWxFOVBrUVR1Iiwic3ViIjo1MiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.ji9Y7vFtUCkZPJZx71BYIomMlcZ8Aw1EUdmKtv_tCio",
    "leagues": [
        {
            "id": 2,
            "name": "A Really Loooooooong name for a league",
            "ownLeague": false,
            "ownTeam": {
                "id": 10,
                "name": "Matt's Novice Team",
                "manager_id": 37,
                "crest_id": 2,
                "pitch_id": null,
                "is_approved": true,
                "is_ignored": false,
                "uuid": "32038c67-9178-46d2-9fae-aac02b405bbb",
                "team_budget": null,
                "created_at": "2019-03-13 13:17:39",
                "updated_at": "2019-03-13 13:17:39",
                "pivot": {
                    "division_id": 2,
                    "team_id": 10,
                    "payment_id": null,
                    "season_id": 19
                }
            },
            "price": "0.00",
            "is_preauction_state": true,
            "is_inauction_state": false,
            "is_paid": true,
            "package_id": 5,
            "introduction": null,
            "parent_division_id": null,
            "auction_types": "Online sealed bids",
            "auction_date": "2019-05-17 09:00:38",
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
            "co_chairman_id": [
                1
            ],
            "co_chairman": [
                {
                    "id": 1,
                    "user_id": 1,
                    "dob": "1986-10-05T00:00:00.000000Z",
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
                        "last_login_at": "2019-03-18T05:58:28.000000Z"
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
                "allow_fa_cup": "Yes",
                "allow_champion_league": "Yes",
                "allow_europa_league": "Yes",
                "allow_head_to_head": "No",
                "allow_linked_league": "Yes",
                "allow_custom_scoring": "No"
            },
            "championLeague": 6,
            "europaLeague": 6,
            "europeanCups": true,
            "teams": [
                {
                    "id": 6,
                    "name": "Ben's Novice Team",
                    "manager_id": 35,
                    "crest_id": 4,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "83b77f0f-6b61-4d37-bfff-08ca199ae865",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/4/conversions/2ee6a052cd140814c6ef69739886b198-thumb.jpg",
                    "remaining_budget": 8.5,
                    "manager": null
                },
                {
                    "id": 7,
                    "name": "Richard's Novice Team",
                    "manager_id": 34,
                    "crest_id": 4,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "63d720be-8c2b-472d-a0ad-4ed96978bfe0",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/4/conversions/2ee6a052cd140814c6ef69739886b198-thumb.jpg",
                    "remaining_budget": 4.9,
                    "manager": null
                },
                {
                    "id": 8,
                    "name": "Johan's Novice Team",
                    "manager_id": 23,
                    "crest_id": 3,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "6d910117-3d01-428e-93a1-8186e4e35ac7",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/3/conversions/21f2b1f541739d592e19cdcd5e56ebbb-thumb.jpg",
                    "remaining_budget": 8.4,
                    "manager": {
                        "id": 23,
                        "first_name": "Josie",
                        "last_name": "O'Conner",
                        "email": "torphy.major@example.com",
                        "username": null,
                        "status": "Active",
                        "last_login_at": null
                    }
                },
                {
                    "id": 9,
                    "name": "Stuart's Novice Team",
                    "manager_id": 38,
                    "crest_id": 3,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "f35d6544-6d90-4069-8adb-e002e87a92bd",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/3/conversions/21f2b1f541739d592e19cdcd5e56ebbb-thumb.jpg",
                    "remaining_budget": 9.7,
                    "manager": null
                },
                {
                    "id": 10,
                    "name": "Matt's Novice Team",
                    "manager_id": 37,
                    "crest_id": 2,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "32038c67-9178-46d2-9fae-aac02b405bbb",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/2/conversions/ebd4e26a25fba430a617378d0ef1895f-thumb.jpg",
                    "remaining_budget": 8.3,
                    "manager": null
                },
                {
                    "id": 126,
                    "name": "test Championship",
                    "manager_id": 39,
                    "crest_id": 1,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "8b23183f-dd27-4ee5-a634-90d194467b83",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/1/conversions/859f20049f4b184f79cd31f1e150ce80-thumb.jpg",
                    "remaining_budget": 9.5,
                    "manager": null
                },
                {
                    "id": 199,
                    "name": "Johan's Other Team",
                    "manager_id": 84,
                    "crest_id": 1,
                    "pitch_id": null,
                    "is_approved": false,
                    "is_paid": true,
                    "uuid": "1fe350ad-b872-417c-8395-191569e91293",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/1/conversions/859f20049f4b184f79cd31f1e150ce80-thumb.jpg",
                    "remaining_budget": 2,
                    "manager": {
                        "id": 84,
                        "first_name": "Ben",
                        "last_name": "GTEST3",
                        "email": "bgrout+fl5@aecordigital.com",
                        "username": "bgrout+fl5@aecordigital.com",
                        "status": "Active",
                        "last_login_at": null
                    }
                },
                {
                    "id": 212,
                    "name": "Hello Team",
                    "manager_id": 35,
                    "crest_id": 2,
                    "pitch_id": null,
                    "is_approved": true,
                    "is_paid": true,
                    "uuid": "671c339f-e37e-4253-901c-777c31517f92",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/2/conversions/ebd4e26a25fba430a617378d0ef1895f-thumb.jpg",
                    "remaining_budget": 7.3,
                    "manager": null
                },
                {
                    "id": 214,
                    "name": "Johan's Team TEST",
                    "manager_id": 89,
                    "crest_id": null,
                    "pitch_id": null,
                    "is_approved": false,
                    "is_paid": true,
                    "uuid": "9439800e-9d29-4e31-b7d2-50078270eaec",
                    "crest_url": "https://fantasyleague-qa.s3.amazonaws.com/60/conversions/Johan_Haynes-thumb.jpg",
                    "remaining_budget": 3,
                    "manager": {
                        "id": 89,
                        "first_name": "hgg",
                        "last_name": "ghgh",
                        "email": "hh@fgf.com",
                        "username": "hh@fgf.com",
                        "status": "Active",
                        "last_login_at": null
                    }
                }
            ],
            "champions_league_team": 10,
            "europa_league_team_1": 6,
            "europa_league_team_2": 8,
            "changeNotAllowed": true,
            "customCups": [
                {
                    "id": 4,
                    "name": "Update",
                    "division_id": 2,
                    "is_bye_random": false,
                    "status": "Active",
                    "created_at": "2019-04-01 09:28:50",
                    "updated_at": "2019-05-03 13:37:30"
                },
                {
                    "id": 12,
                    "name": "Eeee",
                    "division_id": 2,
                    "is_bye_random": true,
                    "status": "Active",
                    "created_at": "2019-04-04 12:08:37",
                    "updated_at": "2019-05-03 13:37:30"
                },
                {
                    "id": 13,
                    "name": "Ffffttt",
                    "division_id": 2,
                    "is_bye_random": false,
                    "status": "Active",
                    "created_at": "2019-04-04 12:30:01",
                    "updated_at": "2019-05-03 13:37:30"
                },
                {
                    "id": 14,
                    "name": "My cup",
                    "division_id": 2,
                    "is_bye_random": false,
                    "status": "Active",
                    "created_at": "2019-04-05 05:44:10",
                    "updated_at": "2019-05-03 13:37:30"
                }
            ],
            "auction_venue": "uk",
            "auction_closing_date": null,
            "allow_passing_on_nominations": null,
            "remote_nomination_time_limit": null,
            "remote_bidding_time_limit": null,
            "allow_managers_to_enter_own_bids": null
        }
    }
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "email": [
        "The email field is required."
    ],
    "password": [
        "The password field is required."
    ]
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "These credentials do not match our records."
        ]
    }
}
```
