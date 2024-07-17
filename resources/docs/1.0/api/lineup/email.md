# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## Confirmation email

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/leagues/{division}/team/{team}/supersub/send_emails`|`Bearer Token`|

### URL Params

> {info} 5 will be league id and 27 will be team id.

### Response

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Supersubs confirmation email sent"
}
```
