# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Login](#login_social)

<a name="division_european_cup_update"></a>
## Delete Team Player

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/team/{team}/player/{player}/destroy`|`Bearer Token`|

### URL Params

```text
None
```


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Data have been deleted successfully."
}
```

> {danger} Error Response
Code `422`

Reason `Update Error`

Content

```json
{
    "status": "error",
    "message": "Invalid request"
}
```
