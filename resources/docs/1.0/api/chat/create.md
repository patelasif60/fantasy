# Store Chat Message

---
- [Store Chat](#create_chat)

<a name="create_chat"></a>
## Store Chat Message

This will store chat message.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/chat/create`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`message`|`string`|`required`|Ex: `Hello test from API`

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
        "message": [
            "The message field is required."
        ]
    }
}
```

