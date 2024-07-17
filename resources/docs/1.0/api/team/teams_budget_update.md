# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Teams Budget Update](#budget_update)

<a name="budget_update"></a>
## Teams Budget Update

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/{division}/teams/budget/update`|`Bearer Token`|

### URL Params

```text
None
```

### Data Params

```json
{
        
}
```

> {info} All parameter should be present in request.

|Params|Type|Values|Example|
|:-|:-|:-|
|`data`|Json|`required`|Ex:`{"budget_correction":{"41":"15.00","38":"13.00","4398":"12.00","45":"10.00","43":"4.00","39":"2.00","46":"2.00","40":"0.00","42":"0.00"},"season_quota_used":{"41":"41","38":"40","4398":"46","45":"35","43":"37","39":"40","46":"35","40":"42","42":"44"},"monthly_quota_used":{"41":"50","38":"50","4398":"50","45":"44","43":"48","39":"50","46":"50","40":"50","42":"50"}}`|


> {success} Success Response

Code `200`

Content

```json
{
     "status": "success",
     "message": "Details have been updated successfully."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "status": "error",
    "message": "Details have not been updated successfully."
    }
}
```

> {danger} Error Response

Code `403`

Reason `Update Error`

Content

```json
{
    "status": "error",
    "message": "Not authorized."
}
```

