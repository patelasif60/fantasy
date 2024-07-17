# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name=""></a>
## Delete Team

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/division/{division}/team/{team}/payment/remove`|Default|


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
