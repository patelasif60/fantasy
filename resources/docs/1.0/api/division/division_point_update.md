# League Players API Docs

---
- [Filters](#league_point_update)

<a name="league_point_update"></a>
## Filters

This will update league points.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{divisionpoint}/points`|`Bearer Token`|

### URL Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`divisionpoint`|`integer`|`required`|Ex: `1`

### DATA Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`columnName`|`String`|`required`|Ex: `goal_keeper`
|`columnValue`|`integer`|`required`|Ex: 10
> {success} Success Response

Code `200`

Content

```json
{
    "success": "Details have been updated successfully."
}
```