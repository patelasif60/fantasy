# Change TransferHistory

---

- [Change History](#change_history)

<a name="change_history"></a>
## Transfer History

This will return transfer history of league.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/transfers/history/list`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`period`|`string`|`optional`|Ex: `7 days`
|`type`|`string`|`optional`|Ex: `Swapdeal`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": [
        {
            "transfer_date": "2019-05-15 00:00:00",
            "name": "Team two",
            "transfer_type": "swapdeal",
            "player_in_first_name": "Asmir",
            "player_in_last_name": "Begovic",
            "player_out_first_name": "Demeaco",
            "player_out_last_name": "Duhaney",
            "user_first_name": "Matt",
            "user_last_name": "Sims",
            "player_in_short_code": "152",
            "player_out_short_code": null
        },
        {
            "transfer_date": "2019-05-15 00:00:00",
            "name": "Team One",
            "transfer_type": "swapdeal",
            "player_in_first_name": "Demeaco",
            "player_in_last_name": "Duhaney",
            "player_out_first_name": "Asmir",
            "player_out_last_name": "Begovic",
            "user_first_name": "Ben",
            "user_last_name": "Grout",
            "player_in_short_code": null,
            "player_out_short_code": "152"
        }
    ]
}
```
> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error",
    "message": "Invalid request"
}
```
