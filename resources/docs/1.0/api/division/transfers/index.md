# Change TransferHistory

---

- [Change History](#change_history)

<a name="change_history"></a>
## Transfer History

This will return transfer history of league.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/transfers/history`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "transferTypes": {
            "sealedbids": "Sealedbids",
            "transfer": "Transfer",
            "trade": "Trade",
            "substitution": "Substitution",
            "budgetcorrection": "Budgetcorrection",
            "supersub": "Supersub",
            "swapdeal": "Swapdeal"
        },
        "periodEnum": {
            "SEVEN_DAYS": "7 days",
            "THIRTY_DAYS": "30 days",
            "SEASON": "Season"
        }
    }
}
```
