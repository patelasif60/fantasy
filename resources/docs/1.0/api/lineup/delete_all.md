# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name=""></a>
## Reset all supersub

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/leagues/{division}/team/supersub/delete_all`|Default|

### Data Params


|Params|Type|Values|Example|
|:-|:-|:-|
|`team_id`|Integer|`required`|Ex:`1`|


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Saved"
}
```

