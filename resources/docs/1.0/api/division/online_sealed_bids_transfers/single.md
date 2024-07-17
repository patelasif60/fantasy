# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name="division_edit"></a>
## Single Process Bid

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/transfers/sealed/bids/process/start/single/{sealbid}`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been saved successfully."
}
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "error",
    "message": "The player has already been transferred to The Moura, The Merrier in this round."
}
```
