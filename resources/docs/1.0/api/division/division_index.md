# League API Docs

---

- [League name validation](#name_validation)
- [League create](#create_league)

<a name="name_validation"></a>
## League name validation

This will validate the league name weather its available or not in the system.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/check`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`name`|`string`|`required`|Ex: `Demo`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "status": "true"
    }
}
```
----
<a name="create_league"></a>
## League create

This will create a new league.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/save/{package}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`package`|`integer`|`valid numeric package id`|Ex: `29`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`name`|`string`|`required`|Ex: `Demo`
|`parent_division_id`|`integer`|`null`|Ex: `27`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "division": {
            "name": "Demo",
            "chairman_id": 10,
            "package_id": 2,
            "introduction": "",
            "parent_division_id": 0,
            "updated_at": "2019-01-30 06:49:48",
            "created_at": "2019-01-30 06:49:48",
            "id": 11
        },
        "invitation": {
            "division_id": 11,
            "user_id": 10,
            "code": "C20AD4",
            "updated_at": "2019-01-30 06:49:50",
            "created_at": "2019-01-30 06:49:50",
            "id": 37
        }
    }
}
```
