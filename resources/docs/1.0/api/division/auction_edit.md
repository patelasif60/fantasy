# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="auction_edit"></a>
## League auction details

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/leagues/{id}/auction/settings`|`Bearer Token`|

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
        "id": 18,
        "name": "Championship Test 09-05",
        "auction_types": "Online sealed bids",
        "auction_date": "2018-05-04 15:00:00",
        "pre_season_auction_budget": 200,
        "pre_season_auction_bid_increment": 1,
        "budget_rollover": "No",
        "auction_venue": "london",
        "manual_bid": "No",
        "tie_preference": "no",
        "allow_passing_on_nominations": null,
        "remote_nomination_time_limit": null,
        "remote_bidding_time_limit": null,
        "allow_managers_to_enter_own_bids": null,
        "auctioneer_id": null,
        "auction_closing_date": null,
        "auction_started": "true"
        "auctionRounds": [
            {
                "id": 155,
                "division_id": 18,
                "start": "2020-05-04 15:00:00",
                "end": "2020-05-05 15:00:00",
                "number": 1
            },
            {
                "id": 156,
                "division_id": 18,
                "start": "2020-05-05 15:00:00",
                "end": "2019-05-24 10:12:57",
                "number": 2
            },
            {
                "id": 157,
                "division_id": 18,
                "start": "2019-05-24 10:12:57",
                "end": "2019-05-25 10:12:57",
                "number": 3
            }
        ]
    },
    "divisions": {
        "1": "Famous five",
        "2": "Championship LON",
        "3": "Rozella",
        "4": "Benton",
        "5": "Angelica",
        "6": "Aditya",
        "7": "Hank",
        "9": "Laurianne",
        "11": "Odell",
        "13": "League Seal",
        "14": "Championship",
        "15": "Championship125",
        "16": "Auction Test Div",
        "17": "League Command",
        "19": "Championship Test 09-05",
        "20": "LiveOnlineAuction League",
        "21": "Johan's League 007",
        "23": "Nirav's League",
        "24": "Sharvari's League",
        "25": "Nirav's League Enum",
        "29": "Nirav's League API",
        "40": "Usama's League",
        "42": "Usama's League2",
        "43": "Matt's League",
        "46": "Rishabh's League",
        "56": "Test league usama",
        "57": "Sunny's League",
        "58": "Johan's League333",
        "59": "Johan's League55",
        "60": "Johan's League77",
        "61": "Johan's League458"
    },
    "yesNo": {
        "Yes": "Yes",
        "No": "No"
    },
    "auctionTypesEnum": {
        "Online sealed bids": "Online sealed bids auction",
        "Live online": "Live online auction",
        "Live offline": "Live offline auction"
    },
    "tiePreferenceEnum": {
        "no": "No tie preference",
        "earliestBidWins": "Earliest bid wins",
        "lowerLeaguePositionWins": "Lower league position wins",
        "higherLeaguePositionWins": "Higher league position wins",
        "randomlyAllocated": "Randomly allocated",
        "randomlyAllocatedReverses": "Randomly allocated, then reverses each round"
    },
    "auctioneers": [
        {
            "id": 35,
            "name": "Johan Haynes"
        },
        {
            "id": 37,
            "name": "Matt Sims"
        }
    ]
}
```
