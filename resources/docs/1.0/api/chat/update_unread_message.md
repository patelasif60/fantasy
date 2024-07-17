# Update Unread Messages

---

- [Update Unread Messages](#update_unread_message)

<a name="update_unread_message"></a>
## Update Unread Messages

This will update chat messages as read.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/chat/read`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`current_time`|`string`|`required`|Ex: `2019-03-22 06:52:06`|


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success.",
    "message": "Details have been saved successfully."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error.",
    "message": {
        "current_time": [
            "The current time field is required."
        ]
    }
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error.",
    "message": {
        "current_time": [
            "The current time does not match the format Y-m-d H:i:s."
        ]
    }
}
```

