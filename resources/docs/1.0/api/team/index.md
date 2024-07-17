# Team API Docs

---

- [Teams list](#teams_list)
- [Create team](#create_team)
- [Edit team](#edit_team)
- [Update team](#update_team)
- [Crest list](#crest_list)
- [Pitches list](#pitch_list)


<a name="teams_list"></a>
## Teams list

This will list all teams of current user.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/teams`|`Bearer Token`|

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 116,
            "name": "Sample Transfer Team",
            "manager_id": 9,
            "crest_id": 1,
            "pitch_id": 4,
            "uuid": "cb197669-1f9d-4ebe-b2b4-14d141e94503"
        },
        {
            "id": 120,
            "name": "team123",
            "manager_id": 9,
            "crest_id": null,
            "pitch_id": null,
            "uuid": "188a5116-3972-4fd9-bd54-421dbaa7447e"
        }
    ]
}
```
----
<a name="create_team"></a>
## Create Team

This will create team for selected division.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/division/create/team/{division}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`required`|Ex: `11`

### Data Params


|Param|Type|Value|Example
|:-|:-|:-|:-
|`name`|`string`|`optional`|Ex: `Team1`
|`crest_id`|`integer`|`optional`|Ex: `3`
|`crest`|`string`|`optional`|`Base64 image string`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 117,
        "name": "Team1",
        "manager_id": 10,
        "crest_id": null,
        "pitch_id": null,
        "uuid": "5d35b1c4-f3af-425b-a270-4c35d0686442"
    }
}
```
----
<a name="edit_team"></a>
## Edit Team

This will display all the details of a team.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/teams/{team}/data`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`team`|`integer`|`required`|Ex: `15`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 15,
        "name": "Schustermouth Athletic",
        "manager_id": 3,
        "crest_id": 1,
        "pitch_id": null,
        "uuid": "d496abee-da11-4c9d-8059-9cd01269da60"
    }
}
```
----
<a name="update_team"></a>
## Update Team

This will update the details of team.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/teams/{team}/update`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`team`|`integer`|`required`|Ex: `15`

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`name`|`string`|`optional`|Ex: `Team1`
|`crest_id`|`integer`|`optional`|Ex: `3`
|`pitch_id`|`integer`|`optional`|Ex: `1`
|`crest`|`string`|`optional`|`Base64 image string`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 15,
        "name": "Schustermouth Athletic",
        "manager_id": 3,
        "crest_id": 1,
        "pitch_id": null,
        "uuid": "d496abee-da11-4c9d-8059-9cd01269da60"
    }
}
```
----
<a name="crest_list"></a>
## Crest List

This will provide list of all predefined crests.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/select/crest`|`Bearer Token`|

### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 1,
            "name": "Test crest",
            "is_published": true,
            "image": "https://fantasyleague-dev.s3.amazonaws.com/25/conversions/300X200-thumb.jpg"
        }
    ]
}
```
----
<a name="pitch_list"></a>
## Pitches List

This will provide list of all available published pitches.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/division/select/pitch`|`Bearer Token`|

### URL Params

```text
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 1,
            "name": "Pitch 1",
            "pitch": null,
            "is_published": true,
            "image": "//via.placeholder.com/140x100?text=No+Image"
        },
        {
            "id": 4,
            "name": "Pitch 2",
            "pitch": null,
            "is_published": true,
            "image": "//via.placeholder.com/140x100?text=No+Image"
        },
        {
            "id": 5,
            "name": "Pitch 3",
            "pitch": null,
            "is_published": true,
            "image": "//via.placeholder.com/140x100?text=No+Image"
        },
        {
            "id": 6,
            "name": "Pitch 4",
            "pitch": null,
            "is_published": true,
            "image": "https://fantasyleague-dev.s3.amazonaws.com/109/conversions/900X500-thumb.jpg"
        },
        {
            "id": 9,
            "name": "Pitch 5",
            "pitch": null,
            "is_published": false,
            "image": "https://fantasyleague-dev.s3.amazonaws.com/120/conversions/15622411974_91efa43dfb_k-thumb.jpg"
        }
    ]
}
```
----