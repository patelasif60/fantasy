# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## FA Cup Standings

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/11/info/fa_cup`|`Bearer Token`|

### URL Params

> {info} All parameter should be present in request.

> {success} Success Response

Code `200`

Content

```json
{
    "teams": [
        {
            "teamName": "Team Affan",
            "teamId": 98,
            "total_goal": "7",
            "total_assist": "7",
            "total_clean_sheet": "7",
            "total_conceded": "7",
            "total_point": "5",
            "first_name": "Affan",
            "last_name": "kheruwala"
        },
        {
            "teamName": "Team Nirav",
            "teamId": 97,
            "total_goal": "2",
            "total_assist": "2",
            "total_clean_sheet": "2",
            "total_conceded": "2",
            "total_point": "2",
            "first_name": "Nirav",
            "last_name": "Patel"
        },
        {
            "teamName": "Sunny Team",
            "teamId": 99,
            "total_goal": null,
            "total_assist": null,
            "total_clean_sheet": null,
            "total_conceded": null,
            "total_point": null,
            "first_name": "Sunny",
            "last_name": "Sheth"
        }
    ],
    "allRounds": {
        "3rd Round": {
            "name": "3rd Round",
            "title": "Round",
            "text": "3"
        },
        "4th Round": {
            "name": "4th Round",
            "title": "Round",
            "text": "4"
        },
        "5th Round": {
            "name": "5th Round",
            "title": "Round",
            "text": "5"
        },
        "Quarter-finals": {
            "name": "Quarter-finals",
            "title": "CF",
            "text": ""
        },
        "Semi-finals": {
            "name": "Semi-finals",
            "title": "SF",
            "text": ""
        },
        "Final": {
            "name": "Final",
            "title": "Final",
            "text": ""
        }
    },
    "playedRounds": [
        "3rd Round",
        "4th Round",
        "5th Round"
    ]
}
```
