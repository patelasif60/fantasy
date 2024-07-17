# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name=""></a>
## History store

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/leagues/2/history/store`|Default|

### URL Params

> {info} 2 will be league id in URL.

### Data Params


|Params|Type|Values|Example|
|:-|:-|:-|
|`name`|String|`required`|Ex:`Ori Dotson`|
|`season_id`|int|`required`|Ex:`6` Season Id |

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been saved successfully."
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
        "name": [
            "The name field is required."
        ],
        "season_id": [
            "The season id has already been taken."
        ]
    }
}
```
