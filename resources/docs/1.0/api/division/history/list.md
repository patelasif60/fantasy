# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## History List

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GEt|`api/leagues/2/history`|`Bearer Token`|

### URL Params

> {info} 2 will be league id in URL.

### Response

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 20,
            "name": "Keelie Macdonald",
            "created_at": {
                "date": "2019-04-02 09:56:16.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-04-02 09:56:16.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "season": {
                "id": 1,
                "name": "2000 - 2001",
                "start_at": {
                    "date": "2000-08-28 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "end_at": {
                    "date": "2001-04-03 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        },
        {
            "id": 21,
            "name": "Kiara Carr",
            "created_at": {
                "date": "2019-04-02 10:01:04.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-04-02 10:01:04.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "season": {
                "id": 2,
                "name": "2001 - 2002",
                "start_at": {
                    "date": "2001-08-14 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "end_at": {
                    "date": "2002-04-27 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        },
        {
            "id": 22,
            "name": "Nathaniel Craft",
            "created_at": {
                "date": "2019-04-02 10:01:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-04-02 10:01:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "season": {
                "id": 3,
                "name": "2002 - 2003",
                "start_at": {
                    "date": "2002-08-08 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "end_at": {
                    "date": "2003-04-22 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        },
        {
            "id": 23,
            "name": "Dara Jordan",
            "created_at": {
                "date": "2019-04-02 10:01:17.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-04-02 10:01:17.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "season": {
                "id": 4,
                "name": "2003 - 2004",
                "start_at": {
                    "date": "2003-08-03 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "end_at": {
                    "date": "2004-04-12 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        },
        {
            "id": 24,
            "name": "Dean Gaines",
            "created_at": {
                "date": "2019-04-02 10:01:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-04-02 10:01:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "season": {
                "id": 5,
                "name": "2004 - 2005",
                "start_at": {
                    "date": "2004-08-14 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "end_at": {
                    "date": "2005-04-10 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        },
        {
            "id": 25,
            "name": "Demetrius Sexton",
            "created_at": {
                "date": "2019-04-02 10:01:31.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2019-04-02 10:01:31.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "season": {
                "id": 6,
                "name": "2005 - 2006",
                "start_at": {
                    "date": "2005-08-21 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "end_at": {
                    "date": "2006-04-26 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                }
            }
        }
    ]
}
```
