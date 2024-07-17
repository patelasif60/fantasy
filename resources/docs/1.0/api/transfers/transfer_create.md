# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_european_cup_update"></a>
## Validate Team Player Formation


### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/team/{team}/create`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`player_ids`|json|`required`|Ex:`[8,40,11,14,135,246,33,69,117,272,287,76,161]`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "valid Formation."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error",
    "message": "Invalid Formation. Transfer were not successfully processed"
}
```
