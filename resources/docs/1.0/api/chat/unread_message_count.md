# Get Unread Message Count

---
- [Filters](#unread_message_count)

<a name="unread_message_count"></a>
## Filters

This will return unread message count.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/chat/unread`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success.",
    "unread": 3
}
```
