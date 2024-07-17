# Delete chat message

---
- [Delete chat](#delete)

<a name="delete"></a>
## Delete chat message

This will store chat message.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/chat/{chat}/delete`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success.",
    "message": "Data have been deleted successfully."
}
```
