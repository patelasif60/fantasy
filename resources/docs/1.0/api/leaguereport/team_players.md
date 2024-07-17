# League Team Players API Docs

---

- [League Teams](#league_teams_list)
- [League Teams Players](#league_teams_players)

<a name="league_teams_list"></a>
## League teams list

This will return list of teams under league.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/report/league/{division}/teams`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/report/league/1/teams`

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 1,
            "name": "Wilbertfurt Wanderers",
            "manager_id": 30,
            "crest_id": 1,
            "pitch_id": null,
            "uuid": "8f3504ae-5fe0-49cb-9f30-ca07e830367b",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/1-thumb.jpg",
            "remaining_budget": 6.8,
            "consumer": {
                "id": 30,
                "user_id": 44,
                "dob": {
                    "date": "1995-03-06 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "23004 Tiara Valley Apt. 134",
                "address_2": "Upton Street",
                "town": "Libbieland",
                "county": "Finland",
                "post_code": "18095-1001",
                "country": "Costa Rica",
                "telephone": "1-676-708-4169",
                "country_code": "+41",
                "favourite_club": "Chelsea FC",
                "introduction": "PRECIOUS nose'; as an.",
                "has_games_news": false,
                "has_fl_marketing": true,
                "has_third_parities": false,
                "user": {
                    "id": 44,
                    "first_name": "Gisselle",
                    "last_name": "Gusikowski",
                    "email": "matt18@example.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 2,
            "name": "Jerdeshire Athletic",
            "manager_id": 26,
            "crest_id": 3,
            "pitch_id": null,
            "uuid": "bdedd165-6f25-40cb-b530-5a492f0ece6f",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/2-thumb.jpg",
            "remaining_budget": 3.4,
            "consumer": {
                "id": 26,
                "user_id": 40,
                "dob": {
                    "date": "1983-02-06 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "34100 Hirthe Tunnel Apt. 047",
                "address_2": "Immanuel Expressway",
                "town": "Melvinmouth",
                "county": "Ethiopia",
                "post_code": "88568-8754",
                "country": "Cyprus",
                "telephone": "467-259-2152 x889",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "English. 'I don't think they play at all know whether it was impossible to say 'creatures,' you see, because some of YOUR business, Two!' said Seven. 'Yes, it IS.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 40,
                    "first_name": "Tracey",
                    "last_name": "Herman",
                    "email": "muller.roger@example.org",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 3,
            "name": "East Rogerview United",
            "manager_id": 14,
            "crest_id": 2,
            "pitch_id": null,
            "uuid": "89db0f47-4d95-4005-a1c6-e76ab9e5bf6b",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/3-thumb.jpg",
            "remaining_budget": 5.8,
            "consumer": {
                "id": 14,
                "user_id": 28,
                "dob": {
                    "date": "1995-03-20 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "80234 Sanford Bridge Apt. 344",
                "address_2": "Gorczany Pike",
                "town": "Brekkeland",
                "county": "Fiji",
                "post_code": "06416",
                "country": "Netherlands Antilles",
                "telephone": "(363) 448-2873 x5237",
                "country_code": "+41",
                "favourite_club": "Manchester United",
                "introduction": "Alice thought this must be getting home; the night-air doesn't suit my throat!' and a piece of rudeness was more than Alice could see her after.",
                "has_games_news": false,
                "has_fl_marketing": true,
                "has_third_parities": false,
                "user": {
                    "id": 28,
                    "first_name": "Shana",
                    "last_name": "Heathcote",
                    "email": "vernie02@example.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 4,
            "name": "East Kristofer Athletic",
            "manager_id": 10,
            "crest_id": 4,
            "pitch_id": null,
            "uuid": "4eba99c5-5807-4064-97f8-811da9acade6",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/4-thumb.jpg",
            "remaining_budget": 2.9,
            "consumer": {
                "id": 10,
                "user_id": 24,
                "dob": {
                    "date": "1987-02-12 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "33558 Kaya Points",
                "address_2": "Berry Plaza",
                "town": "East Lucinda",
                "county": "Moldova",
                "post_code": "36420",
                "country": "Azerbaijan",
                "telephone": "627-270-2607 x403",
                "country_code": "+41",
                "favourite_club": "Arsenal",
                "introduction": "When the Mouse was swimming away from him, and very angrily. 'A knot!' said Alice.",
                "has_games_news": true,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 24,
                    "first_name": "Geovanni",
                    "last_name": "Simonis",
                    "email": "carrie.schroeder@example.com",
                    "username": null,
                    "status": "Active",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 5,
            "name": "Rauview Wanderers",
            "manager_id": 28,
            "crest_id": 5,
            "pitch_id": null,
            "uuid": "b9a2f4e0-431e-45c8-a45a-8caea0ca70f9",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/5/conversions/5-thumb.jpg",
            "remaining_budget": 8.3,
            "consumer": {
                "id": 28,
                "user_id": 42,
                "dob": {
                    "date": "1972-03-06 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "951 Kaela Loop Apt. 313",
                "address_2": "Julio Cove",
                "town": "Howeberg",
                "county": "Cameroon",
                "post_code": "29083-5481",
                "country": "Solomon Islands",
                "telephone": "+1.469.692.0955",
                "country_code": "+41",
                "favourite_club": "Manchester United",
                "introduction": "Mock Turtle; 'but it seems to like her, down here, that I should think you might knock, and I could let you out, you know.' It was, no doubt: only Alice did not notice this question, but hurriedly went on, '--likely to win.",
                "has_games_news": false,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 42,
                    "first_name": "Shawn",
                    "last_name": "Kris",
                    "email": "lyda.kulas@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        }
    ]
}
```
----
<a name="league_teams_players"></a>
## League Team Players

This will return league team players.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/report/league/{division}/team/{team}/players`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `/api/report/league/1/team/1/players`
|`team`|`integer`|`required`|Ex: `/api/report/league/1/team/1/players`

> {success} Success Response
teamPlayers
Code `200`

Content

```json
{
    "data": [
        {
            "position": "CB",
            "player_first_name": "Adam",
            "player_last_name": "Smith",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "ST",
            "player_first_name": "Callum",
            "player_last_name": "Wilson",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Jefferson Andrés",
            "player_last_name": "Lerma Solís",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "DMF",
            "player_first_name": "Jordon",
            "player_last_name": "Ibe",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "MF",
            "player_first_name": "Kyle",
            "player_last_name": "Taylor",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "ST",
            "player_first_name": "Lys",
            "player_last_name": "Mousset",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        },
        {
            "position": "GK",
            "player_first_name": "Mark",
            "player_last_name": "Travers",
            "manager_first_name": "Gisselle",
            "manager_last_name": "Gusikowski",
            "club_name": "AFC Bournemouth",
            "team_name": "Wilbertfurt Wanderers",
            "transfer_value": null,
            "goal": null,
            "assist": null,
            "clean_sheet": null,
            "conceded": null,
            "appearance": null,
            "total": null
        }
    ]
}
```
