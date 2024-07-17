# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

- [Create Link Leagues](#create_league)

<a name="create_league"></a>
## Create Link Leagues


### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/linkedLeagues/save/leagues`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `1`
|`linkLeagueName`|`String`|`required`|Ex: `Test App Link League`
|`childLeagues`|`Array`|`required`|Ex: `[1,2,3]`


### Data Params Example

```json
{
    "linkLeagueName": "Test App Link League",
    "childLeagues": [1,2,3]
}
```


> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been saved successfully."
}
```

> {error} Error Response

Code `422`

Content

```json
{
    "status": "error",
    "message": "Invalid request"
}
```
