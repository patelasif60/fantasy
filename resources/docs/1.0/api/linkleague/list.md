# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Get Link League](#get_link_league)

<a name="get_link_league"></a>
## Link League List

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/league/{division}/getLinkedLeagues`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "parent_linked_league_id": 12,
            "name": "New access league",
            "consumer_id": 6,
            "first_name": "Matt",
            "last_name": "Sims"
        }
    ]
}
```
