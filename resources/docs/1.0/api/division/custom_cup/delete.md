# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## Custom cup delete

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/leagues/5/custom/cups/27/delete`|`Bearer Token`|

### URL Params

> {info} 5 will be league id and 27 will be custom cup id.

### Response

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

Content

```json
{
    "status": "error",
    "message": "Data could not be deleted at this time. Please try again later."
}
```
