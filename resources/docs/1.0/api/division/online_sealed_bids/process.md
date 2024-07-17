# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Manually Process Bids

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{divisionId}/sealed/bids/process/start`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Please wait we are processing your bids."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error",
    "message": "Something went wrong."
}
```
