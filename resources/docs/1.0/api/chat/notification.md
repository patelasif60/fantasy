# User Push Registartion ID Update

---
- [Filters](#notification)

<a name="notification"></a>
## Filters

This will update user push registration id.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/notification`|`Bearer Token`|


### DATA Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`push_registration_id`|`string`|`required`|Ex: `dssjf4wxrts:APA91bGhT3qW8`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success.",
    "message": "Details have been updated successfully."
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
        "push_registration_id": [
            "The push registration id field is required."
        ]
    }
}
```
