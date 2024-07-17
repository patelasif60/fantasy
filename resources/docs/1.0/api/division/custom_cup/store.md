# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---

<a name=""></a>
## Custom cup store

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`api/leagues/5/custom/cups/store`|Default|

### Data Params with Bye teams


|Params|Type|Values|Example|
|:-|:-|:-|
|`name`|String|`required`|Ex:`Ori Dotson`|
|`teams[0]`|int|`required`|Ex:`6` Team ID |
|`teams[1]`|int|`required`|Ex:`8` Team ID|
|`teams[2]`|int|`required`|Ex:`10` Team ID|
|`teams[3]`|int|`required`|Ex:`21` Team ID|
|`teams[4]`|int|`required`|Ex:`22` Team ID|
|`teams[5]`|int|`required`|Ex:`24` Team ID|
|`teams[6]`|int|`required`|Ex:`61` Team ID|
|`teams[7]`|int|`required`|Ex:`63` Team ID|
|`teams[8]`|int|`required`|Ex:`64` Team ID|
|`teams[9]`|int|`required`|Ex:`65` Team ID|
|`teams[10]`|int|`required`|Ex:`66` Team ID|
|`teams[11]`|int|`required`|Ex:`68` Team ID|
|`teams[12]`|int|`required`|Ex:`69` Team ID|
|`teams[13]`|int|`required`|Ex:`70` Team ID|
|`teams[14]`|int|`required`|Ex:`71` Team ID|
|`rounds[1][0]`|int|`required`|Ex:`35` Gameweek ID|
|`rounds[1][1]`|int|`required`|Ex:`36` Gameweek ID|
|`rounds[2][0]`|int|`required`|Ex:`37` Gameweek ID|
|`rounds[2][1]`|int|`required`|Ex:`38` Gameweek ID|
|`rounds[3][0]`|int|`required`|Ex:`39` Gameweek ID|
|`rounds[3][1]`|int|`required`|Ex:`40` Gameweek ID|
|`rounds[4][0]`|int|`required`|Ex:`41` Gameweek ID|
|`is_bye_random`|int|`required`|Ex:`1` |
|`bye_teams[0]`|int|`required`|Ex:`61` Team ID |

### Data Params without Bye teams


|Params|Type|Values|Example|
|:-|:-|:-|
|`name`|String|`required`|Ex:`Keith Horne`|
|`teams[0]`|int|`required`|Ex:`6` Team ID |
|`teams[1]`|int|`required`|Ex:`7` Team ID|
|`teams[2]`|int|`required`|Ex:`8` Team ID|
|`teams[3]`|int|`required`|Ex:`9` Team ID|
|`rounds[1][0]`|int|`required`|Ex:`35` Gameweek ID|
|`rounds[1][1]`|int|`required`|Ex:`36` Gameweek ID|
|`rounds[2][0]`|int|`required`|Ex:`37` Gameweek ID|
|`rounds[2][1]`|int|`required`|Ex:`38` Gameweek ID|
|`is_bye_random`|int|`required`|Ex:`0` |

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Details have been saved successfully."
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "bye_teams": [
            "Your cup has required a minimum of 3 bye teams"
        ]
    }
}
```

> {danger} Error Response

Code `422`

Reason `Validation Error`

Content

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "bye_teams": [
            "Your cup has maximum of 1 bye teams"
        ]
    }
}
```
