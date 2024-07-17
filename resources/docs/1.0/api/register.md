# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Register](#register)

<a name="register"></a>
## Register

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/register`|Accept:application/json|

### URL Params

```text
None
```

### Data Params

```json
{
    "first_name":"Ashish",
    "last_name":"Parmar",
    "password":"***",
    "email":"example@example.com",
    "has_games_news":"true",
    "has_third_parities":"true",
}
```

|Params|Type|Values|Example|
|:-|:-|:-|
|`first_name`|String|`required`|Ex:`Ashish`|
|`last_name`|String|`required`|Ex:`Parmar`|
|`password`|String|`required`|Ex:`***`|
|`email`|String|`required`|Ex:`aparmar@aecordigital.com`|
|`has_games_news`|String|`optional`|Ex:``|
|`has_third_parities`|String|`optional`|Ex:``|


> {success} Success Response

Code `200`

Content

```json
{
    "first_name": "Ahsihs",
    "last_name": "Parmar",
    "email": "ap@gmail.com",
    "username": "ap@gmail.com",
    "status": "Active",
    "provider": "email",
    "remember_url": null,
    "updated_at": "2020-01-13 07:00:20",
    "created_at": "2020-01-13 07:00:20",
    "id": 34367,
    "roles": [
        {
            "id": 3,
            "name": "user",
            "guard_name": "web",
            "created_at": "2019-07-09 12:12:23",
            "updated_at": "2019-07-09 12:12:23",
            "pivot": {
                "model_id": 34367,
                "role_id": 3,
                "model_type": "App\\Models\\User"
            }
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
    "message": "The given data was invalid.",
    "errors": {
        "first_name": [
            "The first name field is required."
        ],
        "last_name": [
            "The last name field is required."
        ],
        "email": [
            "The email field is required."
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
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```