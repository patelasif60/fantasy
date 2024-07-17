# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

- [Season](/docs/{{version}}/api/division/league_standings/season)
- [Monthly](/docs/{{version}}/api/division/league_standings/month)
- [Weekly](/docs/{{version}}/api/division/league_standings/week)

---
<a name="division_edit"></a>
## League standings monthly

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{league}/info/league_standings/filter`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`startDate`|Date|`required`|`2019-05-01` (Y-m-d)|
|`endDate`|Date|`required`|`2019-05-30` (Y-m-d)|

> {success} Success Response

Code `200`

Content

```json
{
    "teams": [
        {
            "total_goal": 6,
            "total_assist": 1,
            "total_clean_sheet": 1,
            "total_conceded": 7,
            "total_appearance": 6,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 1,
            "total_club_win": 6,
            "total_point": 31,
            "teamName": "Another Test Team 2",
            "teamId": 161,
            "first_name": "Matt",
            "last_name": "Sims"
        },
        {
            "total_goal": 2,
            "total_assist": 3,
            "total_clean_sheet": 3,
            "total_conceded": 7,
            "total_appearance": 7,
            "total_own_goal": 0,
            "total_red_card": -1,
            "total_yellow_card": 2,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 6,
            "total_point": 26,
            "teamName": "Another Test Team 4",
            "teamId": 163,
            "first_name": "Matt",
            "last_name": "Sims"
        },
        {
            "total_goal": 2,
            "total_assist": 2,
            "total_clean_sheet": 1,
            "total_conceded": 7,
            "total_appearance": 4,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 2,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 6,
            "total_point": 10,
            "teamName": "Another Test Team 5",
            "teamId": 164,
            "first_name": "Matt",
            "last_name": "Sims"
        },
        {
            "total_goal": 1,
            "total_assist": 2,
            "total_clean_sheet": 2,
            "total_conceded": 9,
            "total_appearance": 7,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 2,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 8,
            "total_point": 14,
            "teamName": "Another Test Team 1",
            "teamId": 155,
            "first_name": "Matt",
            "last_name": "Sims"
        },
        {
            "total_goal": 1,
            "total_assist": 0,
            "total_clean_sheet": 3,
            "total_conceded": 5,
            "total_appearance": 6,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 1,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 4,
            "total_point": 9,
            "teamName": "Another Test Team 3",
            "teamId": 162,
            "first_name": "Matt",
            "last_name": "Sims"
        },
        {
            "total_goal": 0,
            "total_assist": 0,
            "total_clean_sheet": 0,
            "total_conceded": 0,
            "total_appearance": 0,
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 0,
            "total_point": 0,
            "teamName": "Ben's Team",
            "teamId": 165,
            "first_name": "Ben",
            "last_name": "Grout"
        }
    ]
}
```
