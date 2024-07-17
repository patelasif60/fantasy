# Chat Messages

---

- [Chat Message](#chat_message)

<a name="chat_message"></a>
## Chat Messages League

This will return chat messages of user.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/league/{division}/chat`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example|Note
|:-|:-|:-|:-
|`noOfRecords`|`string`|`optional`|Ex: `50`|Note:`For first time call only`
|`page`|`string`|`required`|Ex: `2`|Note:`For second time call due to paginaton`


> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "id": 6731,
            "sender_id": "System",
            "message": "Hello This is System Generated Message.",
            "first_name": null,
            "last_name": null,
            "created_at": {
                "date": "2019-03-27 09:16:54.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6730,
            "sender_id": "34",
            "message": "Hey This DP message 5",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 09:16:53.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6729,
            "sender_id": "34",
            "message": "Hey This DP message 4",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 07:05:30.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6728,
            "sender_id": "34",
            "message": "Hello test from API 3.",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 07:04:17.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6727,
            "sender_id": "34",
            "message": "Hello test from API.",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 07:02:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6726,
            "sender_id": "34",
            "message": "Hello test from API.",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 07:01:38.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6725,
            "sender_id": "35",
            "message": "hu hu hu",
            "first_name": "Johan",
            "last_name": "Haynes",
            "created_at": {
                "date": "2019-03-27 06:33:24.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6724,
            "sender_id": "35",
            "message": "he he he",
            "first_name": "Johan",
            "last_name": "Haynes",
            "created_at": {
                "date": "2019-03-27 06:33:16.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6723,
            "sender_id": "35",
            "message": "ho ho ho",
            "first_name": "Johan",
            "last_name": "Haynes",
            "created_at": {
                "date": "2019-03-27 06:33:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6722,
            "sender_id": "34",
            "message": "Hello This is message on 27-03",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 04:57:22.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6721,
            "sender_id": "34",
            "message": "Hiii",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-27 04:56:32.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6720,
            "sender_id": "34",
            "message": "Hello",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-26 13:40:20.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6719,
            "sender_id": "34",
            "message": "Hii am here",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-26 13:13:06.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6718,
            "sender_id": "34",
            "message": "fdssdffd",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-25 13:28:38.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6717,
            "sender_id": "33",
            "message": "Hello Message from rstenson champons League second.",
            "first_name": "Ben",
            "last_name": "Grout",
            "created_at": {
                "date": "2019-03-25 12:53:04.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6716,
            "sender_id": "33",
            "message": "Hello Message from rstenson champons League.",
            "first_name": "Ben",
            "last_name": "Grout",
            "created_at": {
                "date": "2019-03-25 12:52:36.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6715,
            "sender_id": "33",
            "message": "Hello i am brgout message to chamionship league.",
            "first_name": "Ben",
            "last_name": "Grout",
            "created_at": {
                "date": "2019-03-25 12:50:05.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6714,
            "sender_id": "34",
            "message": "Hey this is also today message.",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-25 10:26:14.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6713,
            "sender_id": "34",
            "message": "Hey This is Just test msg from DP 4.",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-25 10:20:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6712,
            "sender_id": "34",
            "message": "Hey This is Just test msg from DP 3",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-25 10:12:21.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6711,
            "sender_id": "34",
            "message": "Hey This is Just test msg from DP.",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-24 10:08:21.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6710,
            "sender_id": "34",
            "message": "Hey This is Just test msg from DP",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-23 11:52:14.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6709,
            "sender_id": "34",
            "message": "dsdsf",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:51:32.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6707,
            "sender_id": "34",
            "message": "dsds",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:50:55.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6706,
            "sender_id": "34",
            "message": "dsffdsdf",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:50:23.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6705,
            "sender_id": "34",
            "message": "fffdfdf",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:48:14.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6704,
            "sender_id": "34",
            "message": "fff",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:47:51.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6703,
            "sender_id": "34",
            "message": "dffff",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:46:42.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6702,
            "sender_id": "34",
            "message": "dsffdsf",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:45:17.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 6701,
            "sender_id": "34",
            "message": "Hey My second message via DP",
            "first_name": "Richard",
            "last_name": "Stenson",
            "created_at": {
                "date": "2019-03-22 11:06:59.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2798,
            "sender_id": "24",
            "message": "Hey this is message no(98) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:13.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2799,
            "sender_id": "24",
            "message": "Hey this is message no(99) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:13.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2800,
            "sender_id": "24",
            "message": "Hey this is message no(100) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:13.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2795,
            "sender_id": "24",
            "message": "Hey this is message no(95) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:12.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2796,
            "sender_id": "24",
            "message": "Hey this is message no(96) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:12.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2797,
            "sender_id": "24",
            "message": "Hey this is message no(97) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:12.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2791,
            "sender_id": "24",
            "message": "Hey this is message no(91) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2792,
            "sender_id": "24",
            "message": "Hey this is message no(92) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2793,
            "sender_id": "24",
            "message": "Hey this is message no(93) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2794,
            "sender_id": "24",
            "message": "Hey this is message no(94) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:11.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2788,
            "sender_id": "24",
            "message": "Hey this is message no(88) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:10.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2789,
            "sender_id": "24",
            "message": "Hey this is message no(89) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:10.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2790,
            "sender_id": "24",
            "message": "Hey this is message no(90) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:10.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2784,
            "sender_id": "24",
            "message": "Hey this is message no(84) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:09.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2785,
            "sender_id": "24",
            "message": "Hey this is message no(85) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:09.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2786,
            "sender_id": "24",
            "message": "Hey this is message no(86) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:09.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2787,
            "sender_id": "24",
            "message": "Hey this is message no(87) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:09.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2780,
            "sender_id": "24",
            "message": "Hey this is message no(80) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2781,
            "sender_id": "24",
            "message": "Hey this is message no(81) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 2782,
            "sender_id": "24",
            "message": "Hey this is message no(82) from #24",
            "first_name": "Vilma",
            "last_name": "Davis",
            "created_at": {
                "date": "2019-03-22 06:52:08.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ],
    "links": {
        "first": "http://irfan-fantasyleague.dev.aecortech.com/api/league/2/chat?page=1",
        "last": "http://irfan-fantasyleague.dev.aecortech.com/api/league/2/chat?page=27",
        "prev": null,
        "next": "http://irfan-fantasyleague.dev.aecortech.com/api/league/2/chat?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 27,
        "path": "http://irfan-fantasyleague.dev.aecortech.com/api/league/2/chat",
        "per_page": 50,
        "to": 50,
        "total": 1331
    }
}
```
