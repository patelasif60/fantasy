# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Free Agents Filters](#free_agents_filters)

<a name="free_agents_filters"></a>
## Free Agents List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/{division}/transfers/get_free_agents`|`Bearer Token`|


### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "positions": {
            "Goalkeeper (GK)": "Goalkeeper",
            "Full-back (FB)": "Fullback",
            "Centre-back (CB)": "Centreback",
            "Midfielder (MF)": "Midfielder",
            "Striker (ST)": "Striker"
        },
        "clubs": [
            {
                "id": 1,
                "name": "AFC Bournemouth"
            }
        ]
    }
}
```
