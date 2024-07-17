# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## History edit

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GEt|`api/leagues/2/history/20/edit`|`Bearer Token`|

### URL Params

> {info} 5 will be league id and 30 will be custom cup id.

### Response

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
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
    "seasons": [
        {
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
        },
        {
            "id": 7,
            "name": "2006 - 2007",
            "start_at": {
                "date": "2006-08-26 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2007-04-13 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 8,
            "name": "2007 - 2008",
            "start_at": {
                "date": "2007-08-05 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2008-04-07 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 9,
            "name": "2008 - 2009",
            "start_at": {
                "date": "2008-08-27 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2009-04-19 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 10,
            "name": "2009 - 2010",
            "start_at": {
                "date": "2009-08-16 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2010-04-13 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 11,
            "name": "2010 - 2011",
            "start_at": {
                "date": "2010-08-10 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2011-04-02 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 12,
            "name": "2011 - 2012",
            "start_at": {
                "date": "2011-08-21 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2012-04-27 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 13,
            "name": "2012 - 2013",
            "start_at": {
                "date": "2012-08-12 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2013-04-09 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 14,
            "name": "2013 - 2014",
            "start_at": {
                "date": "2013-08-01 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2014-04-26 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 15,
            "name": "2014 - 2015",
            "start_at": {
                "date": "2014-08-27 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2015-04-22 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 16,
            "name": "2015 - 2016",
            "start_at": {
                "date": "2015-08-22 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2016-04-04 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 17,
            "name": "2016 - 2017",
            "start_at": {
                "date": "2016-08-16 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2017-04-13 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 18,
            "name": "2017 - 2018",
            "start_at": {
                "date": "2017-08-06 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2018-04-05 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 19,
            "name": "2018 - 2019",
            "start_at": {
                "date": "2018-08-09 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end_at": {
                "date": "2019-05-13 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ]
}
```
