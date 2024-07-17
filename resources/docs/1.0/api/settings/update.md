# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name=""></a>
## Transfers and Sealed bids settings

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`leagues/{division}/transfer/settings/update`|`Bearer Token`|

### Data Params with Bye teams


|Params|Type|Values|Example|
|:-|:-|:-|
|`seal_bids_budget`|String|`Integer`|Ex:`100`|
|`enable_free_agent_transfer`|String|`optional`|Ex:`Yes` `No`|
|`free_agent_transfer_authority`|String|`optional`|Ex:`all`|
|`free_agent_transfer_after`|String|`optional`|Ex:`seasonStart`|
|`season_free_agent_transfer_limit`|Integer|`optional`|Ex:`Ori Dotson`|
|`monthly_free_agent_transfer_limit`|Integer|`optional`|Ex:`Ori Dotson`|
|`seal_bid_deadline_repeat`|String|`optional`|Ex:`dontRepeat`|
|`max_seal_bids_per_team_per_round`|Integer|`optional`|Ex:`1`|
|`seal_bid_increment`|Integer|`optional`|Ex:`0.5`|
|`seal_bid_minimum`|Integer|`optional`|Ex:`1`|
|`money_back`|String|`optional`|Ex:`hunderedPercent`|
|`tie_preference`|String|`optional`|Ex:`lowerLeaguePositionWins`|


Pass data in below format in api to update transfers settings

```json
{
    "seal_bids_budget":"0",
    "enable_free_agent_transfer":"Yes",
    "free_agent_transfer_authority":"all",
    "free_agent_transfer_after":"seasonStart",
    "season_free_agent_transfer_limit":"1000",
    "monthly_free_agent_transfer_limit":"100",
    "seal_bid_deadline_repeat":"dontRepeat",
    "max_seal_bids_per_team_per_round":"5",
    "seal_bid_increment":"0.50",
    "seal_bid_minimum":"0.00",
    "money_back":"hunderedPercent",
    "tie_preference":"lowerLeaguePositionWins",
    "round_end_date": [
            {"579":"31/08/2019"},
            {"914": "11/09/2019"},
            {"919": "11/09/2019"},
            {"1088": "18/09/2019"},
            {"1842": "19/09/2019"},
            {"1845": "17/10/2019"},
            {"1919": "18/10/2019"},
            {"2211": "21/01/2020"},
            {"4485": "22/01/2020"},
            {"0": "23/01/2020"}
        ],
    "round_end_time": [
            {"579":"12:00:00"},
            {"914": "12:00:00"},
            {"919": "15:00:00"},
            {"1088": "12:00:00"},
            {"1842": "14:00:00"},
            {"1845": "14:05:00"},
            {"1919": "10:00:00"},
            {"2211": "11:45:00"},
            {"4485": "14:50:00"},
            {"0": "12:00:00"}
        ]
}
```


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been saved successfully."
}
```