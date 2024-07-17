# API Docs

At [Binary Torch](https://binarytorch.com.my/) we use LaRecipe internally to write docs for our products/services and share the access with our developers. Here is an example of writing API docs in a nice human-readable way.

---
<a name=""></a>
## Custom cup edit

Here you may add extra information about the section.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GEt|`api/leagues/5/custom/cups/30/edit`|`Bearer Token`|

### URL Params

> {info} 5 will be league id and 30 will be custom cup id.

### Response

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "id": 30,
        "name": "Gmm",
        "division_id": 5,
        "is_bye_random": true,
        "status": "Pending",
        "created_at": {
            "date": "2019-04-02 05:45:02.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2019-04-02 05:45:02.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "teamCount": 5,
        "gameweeks": "Configured",
        "first_round_byes": "Select by manager"
    },
    "selectedTeams": [
        {
            "id": 398,
            "custom_cup_id": 30,
            "team_id": 6,
            "is_bye": true,
            "created_at": "2019-04-02 06:34:20",
            "updated_at": "2019-04-02 06:34:20"
        },
        {
            "id": 399,
            "custom_cup_id": 30,
            "team_id": 7,
            "is_bye": true,
            "created_at": "2019-04-02 06:34:20",
            "updated_at": "2019-04-02 06:34:20"
        },
        {
            "id": 400,
            "custom_cup_id": 30,
            "team_id": 9,
            "is_bye": true,
            "created_at": "2019-04-02 06:34:20",
            "updated_at": "2019-04-02 06:34:20"
        },
        {
            "id": 401,
            "custom_cup_id": 30,
            "team_id": 10,
            "is_bye": false,
            "created_at": "2019-04-02 06:34:20",
            "updated_at": "2019-04-02 06:34:20"
        },
        {
            "id": 402,
            "custom_cup_id": 30,
            "team_id": 21,
            "is_bye": false,
            "created_at": "2019-04-02 06:34:20",
            "updated_at": "2019-04-02 06:34:20"
        }
    ],
    "selectedRounds": [
        {
            "id": 164,
            "round": "1",
            "custom_cup_id": 30,
            "gameweeks": [
                {
                    "id": 271,
                    "gameweek_id": 36,
                    "custom_cup_round_id": 164,
                    "gameweek": {
                        "id": 36,
                        "number": "36",
                        "is_valid_cup_round": true,
                        "start": {
                            "date": "2019-04-09 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        },
                        "end": {
                            "date": "2019-04-16 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        }
                    }
                },
                {
                    "id": 272,
                    "gameweek_id": 37,
                    "custom_cup_round_id": 164,
                    "gameweek": {
                        "id": 37,
                        "number": "37",
                        "is_valid_cup_round": false,
                        "start": {
                            "date": "2019-04-16 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        },
                        "end": {
                            "date": "2019-04-23 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        }
                    }
                }
            ]
        },
        {
            "id": 165,
            "round": "2",
            "custom_cup_id": 30,
            "gameweeks": [
                {
                    "id": 273,
                    "gameweek_id": 38,
                    "custom_cup_round_id": 165,
                    "gameweek": {
                        "id": 38,
                        "number": "38",
                        "is_valid_cup_round": true,
                        "start": {
                            "date": "2019-04-23 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        },
                        "end": {
                            "date": "2019-04-30 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        }
                    }
                }
            ]
        },
        {
            "id": 166,
            "round": "3",
            "custom_cup_id": 30,
            "gameweeks": [
                {
                    "id": 274,
                    "gameweek_id": 39,
                    "custom_cup_round_id": 166,
                    "gameweek": {
                        "id": 39,
                        "number": "39",
                        "is_valid_cup_round": true,
                        "start": {
                            "date": "2019-04-30 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        },
                        "end": {
                            "date": "2019-05-07 00:00:00.000000",
                            "timezone_type": 3,
                            "timezone": "UTC"
                        }
                    }
                }
            ]
        }
    ],
    "teams": [
        {
            "id": 6,
            "name": "Ben's Novice Team",
            "manager_id": 33,
            "crest_id": 1,
            "pitch_id": 2,
            "is_approved": true,
            "uuid": "abea4eaf-061a-4933-9b4b-17fc89b1a5c8",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 9,
            "consumer": {
                "id": 33,
                "user_id": 48,
                "dob": {
                    "date": "1975-01-01 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "123 Test Street",
                "address_2": null,
                "town": "Test Town",
                "county": null,
                "post_code": "TE5 T5",
                "country": "UK",
                "telephone": null,
                "country_code": null,
                "favourite_club": null,
                "introduction": null,
                "has_games_news": true,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 48,
                    "first_name": "Ben",
                    "last_name": "Grout",
                    "email": "bgrout+fl1@aecordigital.com",
                    "username": "bgrout",
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-04-01 14:16:17.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 7,
            "name": "Richard's Novice Team",
            "manager_id": 34,
            "crest_id": 4,
            "pitch_id": 2,
            "is_approved": true,
            "uuid": "31d8be6d-d8ac-45c3-8fbf-83e33d3934fc",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/f1c3bc250734b585601a62f11e78ea2e-thumb.jpg",
            "remaining_budget": 3.4,
            "consumer": {
                "id": 34,
                "user_id": 49,
                "dob": {
                    "date": "1970-01-02 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "124 Test Street",
                "address_2": "",
                "town": "Test Town",
                "county": "",
                "post_code": "TE5 T6",
                "country": "UK",
                "telephone": "",
                "country_code": "",
                "favourite_club": "",
                "introduction": "",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 49,
                    "first_name": "Richard",
                    "last_name": "Stenson",
                    "email": "rstenson+fl1@aecordigital.com",
                    "username": "rstenson",
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-04-02 05:33:36.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 8,
            "name": "Johan's Novice Team",
            "manager_id": 35,
            "crest_id": 1,
            "pitch_id": 1,
            "is_approved": true,
            "uuid": "190e5618-f62e-4660-b8fa-a83f69267655",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 3.9,
            "consumer": {
                "id": 35,
                "user_id": 50,
                "dob": {
                    "date": "1970-01-03 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "125 Test Street",
                "address_2": null,
                "town": "Test Town",
                "county": null,
                "post_code": "TE5 T7",
                "country": "UK",
                "telephone": null,
                "country_code": "+44",
                "favourite_club": "Wolverhampton Wanderers",
                "introduction": null,
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 50,
                    "first_name": "Johan",
                    "last_name": "Haynes",
                    "email": "jhaynes+fl1@aecordigital.com",
                    "username": "jhaynes",
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-04-02 05:06:58.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 9,
            "name": "Stuart's Novice Team",
            "manager_id": 38,
            "crest_id": 3,
            "pitch_id": 2,
            "is_approved": true,
            "uuid": "1f3402e6-8c5a-4660-9529-ff22c2de5479",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/201dee3f1714ba211d43fea6d0f529cb-thumb.jpg",
            "remaining_budget": 6,
            "consumer": {
                "id": 38,
                "user_id": 53,
                "dob": {
                    "date": "1970-01-05 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "127 Test Street",
                "address_2": "",
                "town": "Test Town",
                "county": "",
                "post_code": "TE5 T9",
                "country": "UK",
                "telephone": "",
                "country_code": "",
                "favourite_club": "",
                "introduction": "",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 53,
                    "first_name": "Stuart",
                    "last_name": "Walsh",
                    "email": "stuart@thinkandthing.com",
                    "username": "stuartwalsh",
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-03-19 11:10:52.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 10,
            "name": "Matt's Novice Team",
            "manager_id": 37,
            "crest_id": 4,
            "pitch_id": 2,
            "is_approved": true,
            "uuid": "be9124cd-7cbb-48f6-ba6c-0591e2642aac",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/f1c3bc250734b585601a62f11e78ea2e-thumb.jpg",
            "remaining_budget": 5.8,
            "consumer": {
                "id": 37,
                "user_id": 52,
                "dob": {
                    "date": "1970-01-05 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "127 Test Street",
                "address_2": "",
                "town": "Test Town",
                "county": "",
                "post_code": "TE5 T9",
                "country": "UK",
                "telephone": "",
                "country_code": "",
                "favourite_club": "",
                "introduction": "",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 52,
                    "first_name": "Matt",
                    "last_name": "Sims",
                    "email": "matts@fantasyleague.com",
                    "username": "msims",
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-03-28 10:22:48.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 21,
            "name": "Laurie Bizarre Butchers",
            "manager_id": 4,
            "crest_id": 3,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "12911d31-44aa-49e0-9fb1-9c7424cdb52d",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/201dee3f1714ba211d43fea6d0f529cb-thumb.jpg",
            "remaining_budget": 4.4,
            "consumer": {
                "id": 4,
                "user_id": 4,
                "dob": {
                    "date": "2004-12-03 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "8461 Bauch Prairie",
                "address_2": "Brakus Street",
                "town": "Suzannefort",
                "county": "British Virgin Islands",
                "post_code": "03216",
                "country": "Hungary",
                "telephone": "634-804-6655 x6032",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "Why, it fills the whole cause, and condemn you to get through the wood. 'If it had made. 'He took me for asking!.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 4,
                    "first_name": "Gladyce",
                    "last_name": "Miller",
                    "email": "upfannerstill@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 22,
            "name": "Kallie Bizarre Butchers",
            "manager_id": 25,
            "crest_id": 3,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "9235501a-f1fb-40a3-9be2-4b2eb0fac9d8",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/201dee3f1714ba211d43fea6d0f529cb-thumb.jpg",
            "remaining_budget": 9.4,
            "consumer": {
                "id": 25,
                "user_id": 25,
                "dob": {
                    "date": "1980-02-23 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "75813 Fadel Greens",
                "address_2": "Darby Islands",
                "town": "North Nathanial",
                "county": "Palau",
                "post_code": "83303",
                "country": "American Samoa",
                "telephone": "972-419-3172 x8081",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "Mock Turtle angrily: 'really you are painting those roses?' Five and Seven said nothing, but looked at poor Alice, who had been running half an hour or so, and were quite silent, and looked into its eyes again, to see the earth takes twenty-four hours to.",
                "has_games_news": true,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 25,
                    "first_name": "Corrine",
                    "last_name": "Skiles",
                    "email": "april53@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 23,
            "name": "Sonny Enchanting Gang",
            "manager_id": 27,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "98a00511-214b-469a-a8bb-6a82d3650f5e",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/c26f9e293a619d93c4c6006858a12dfb-thumb.jpg",
            "remaining_budget": 3.5,
            "consumer": {
                "id": 27,
                "user_id": 27,
                "dob": {
                    "date": "2018-01-26 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "78686 Marty Lodge",
                "address_2": "Cristina Mountains",
                "town": "Port Camdenburgh",
                "county": "Malawi",
                "post_code": "85749-2768",
                "country": "Svalbard & Jan Mayen Islands",
                "telephone": "(324) 870-4409 x92381",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "Queen.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 27,
                    "first_name": "Nakia",
                    "last_name": "Kozey",
                    "email": "jerde.hazle@example.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 24,
            "name": "Brennan Clowns",
            "manager_id": 29,
            "crest_id": 1,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "78fdcc31-1ae9-46d4-9b9c-50ba26eaac5c",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 2.5,
            "consumer": {
                "id": 29,
                "user_id": 29,
                "dob": {
                    "date": "1976-11-06 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "36447 Madonna Stream Suite 055",
                "address_2": "Marge Trafficway",
                "town": "Howellmouth",
                "county": "Bulgaria",
                "post_code": "27691-2832",
                "country": "Lithuania",
                "telephone": "1-943-940-3185 x1009",
                "country_code": "+41",
                "favourite_club": "Arsenal",
                "introduction": "Mind now!' The poor little thing howled so, that Alice said; 'there's a large crowd collected round it: there was mouth enough for it flashed across.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 29,
                    "first_name": "Jeremy",
                    "last_name": "Fisher",
                    "email": "vida.powlowski@example.net",
                    "username": null,
                    "status": "Active",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 25,
            "name": "Janiya Slayers",
            "manager_id": 3,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "6d816320-fcd5-4526-92e5-5195d8b523a7",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/f1c3bc250734b585601a62f11e78ea2e-thumb.jpg",
            "remaining_budget": 4.3,
            "consumer": {
                "id": 3,
                "user_id": 3,
                "dob": {
                    "date": "1976-12-02 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "12511 Tressie Park",
                "address_2": "Senger Fields",
                "town": "Myraburgh",
                "county": "Bouvet Island (Bouvetoya)",
                "post_code": "39629",
                "country": "Mozambique",
                "telephone": "393-606-5673 x51452",
                "country_code": "+41",
                "favourite_club": "Manchester United",
                "introduction": "Alice. 'Now we shall get on better.' 'I'd rather finish my tea,' said the Queen. An.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 3,
                    "first_name": "Charlotte",
                    "last_name": "Ortiz",
                    "email": "dayna57@example.org",
                    "username": null,
                    "status": "Active",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 26,
            "name": "Itzel Rag Gentlemen",
            "manager_id": 31,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "37330c67-b399-485c-aaeb-f79cc7c622fa",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/c26f9e293a619d93c4c6006858a12dfb-thumb.jpg",
            "remaining_budget": 9.2,
            "consumer": {
                "id": 31,
                "user_id": 31,
                "dob": {
                    "date": "1999-06-11 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "92588 Kohler Groves Suite 909",
                "address_2": "Adolfo Ville",
                "town": "North Keaganstad",
                "county": "Sweden",
                "post_code": "65328",
                "country": "Afghanistan",
                "telephone": "(790) 702-9594",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "I am to see it written up somewhere.' Down, down, down. Would the fall NEVER come to an end! 'I wonder how many hours a day is very.",
                "has_games_news": true,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 31,
                    "first_name": "Calista",
                    "last_name": "Monahan",
                    "email": "elizabeth.bernhard@example.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 27,
            "name": "Manley Slayers",
            "manager_id": 5,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "53b85dd0-3f65-431e-9cf0-b3e05ed1ea72",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/c26f9e293a619d93c4c6006858a12dfb-thumb.jpg",
            "remaining_budget": 5.2,
            "consumer": {
                "id": 5,
                "user_id": 5,
                "dob": {
                    "date": "2000-05-05 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "59973 Paucek Lake",
                "address_2": "Pacocha Park",
                "town": "East Louveniabury",
                "county": "Lebanon",
                "post_code": "02302",
                "country": "Burkina Faso",
                "telephone": "593-592-4473",
                "country_code": "+41",
                "favourite_club": "Arsenal",
                "introduction": "King, rubbing his hands; 'so now let the Dormouse crossed the court, arm-in-arm with the Duchess, 'and that's why. Pig!' She said this she looked down into its eyes by this time).",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 5,
                    "first_name": "Judah",
                    "last_name": "Dare",
                    "email": "moen.chase@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 28,
            "name": "Icie Team",
            "manager_id": 24,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "b0d37a92-d78f-4bbb-bfc5-9b57a8a189aa",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/c26f9e293a619d93c4c6006858a12dfb-thumb.jpg",
            "remaining_budget": 7.1,
            "consumer": {
                "id": 24,
                "user_id": 24,
                "dob": {
                    "date": "2002-06-07 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "3033 Meghan Ridge Suite 597",
                "address_2": "Lebsack Shores",
                "town": "West Camillaburgh",
                "county": "Brunei Darussalam",
                "post_code": "85374",
                "country": "South Africa",
                "telephone": "+16694136928",
                "country_code": "+41",
                "favourite_club": "Arsenal",
                "introduction": "I think.' And she went on, 'that they'd let Dinah stop in the distance would take the hint; but the tops of the hall: in fact she was.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 24,
                    "first_name": "Vilma",
                    "last_name": "Davis",
                    "email": "johnson.anibal@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 61,
            "name": "Maynard FC",
            "manager_id": 12,
            "crest_id": 1,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "3e1b4653-aeba-42aa-bc08-44ab387238aa",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 3.2,
            "consumer": {
                "id": 12,
                "user_id": 12,
                "dob": {
                    "date": "1985-11-08 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "4951 Adams Plaza Suite 884",
                "address_2": "Gardner Burgs",
                "town": "North Beulah",
                "county": "Italy",
                "post_code": "25253",
                "country": "British Indian Ocean Territory (Chagos Archipelago)",
                "telephone": "+1-229-463-3329",
                "country_code": "+41",
                "favourite_club": "Chelsea FC",
                "introduction": "However, she got into a pig, and she felt certain it must be what he did not see anything that had fallen into it: there was enough of me left to make ONE respectable person!' Soon her eye fell upon a little animal (she couldn't guess of what sort it.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 12,
                    "first_name": "Baby",
                    "last_name": "Altenwerth",
                    "email": "jed37@example.net",
                    "username": null,
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-03-20 10:12:07.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 62,
            "name": "Lavon Sharpshooters",
            "manager_id": 2,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "64ecac98-1dae-46a0-9f60-7efb6e2de09b",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/c26f9e293a619d93c4c6006858a12dfb-thumb.jpg",
            "remaining_budget": 8.3,
            "consumer": {
                "id": 2,
                "user_id": 2,
                "dob": {
                    "date": "2006-09-20 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "121 Konopelski Fords Suite 471",
                "address_2": "Gleason Junction",
                "town": "North Aiyanatown",
                "county": "Cocos (Keeling) Islands",
                "post_code": "53985",
                "country": "Marshall Islands",
                "telephone": "1-470-353-3562 x5103",
                "country_code": "+41",
                "favourite_club": "Chelsea FC",
                "introduction": "As they walked off together. Alice was not otherwise than what you would have appeared to them to sell,' the Hatter said, tossing his head contemptuously. 'I dare say there may be different,'.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 2,
                    "first_name": "Nirav",
                    "last_name": "Patel",
                    "email": "npatel@aecordigital.com",
                    "username": null,
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-03-26 07:32:09.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 63,
            "name": "Margaret Scintillating Assassins",
            "manager_id": 16,
            "crest_id": 2,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "20ecd81c-c69d-46ee-abc2-6858bcd78106",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/2/conversions/c26f9e293a619d93c4c6006858a12dfb-thumb.jpg",
            "remaining_budget": 8,
            "consumer": {
                "id": 16,
                "user_id": 16,
                "dob": {
                    "date": "2018-05-06 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "10777 Reagan Common Suite 493",
                "address_2": "Burdette Centers",
                "town": "South Evan",
                "county": "Singapore",
                "post_code": "04451-2162",
                "country": "South Georgia and the South Sandwich Islands",
                "telephone": "+1-823-851-4067",
                "country_code": "+41",
                "favourite_club": "Chelsea FC",
                "introduction": "Alice soon came upon a little sharp bark just over her head through the wood. 'If it had lost something; and she felt very glad to get through was more than three.' 'Your hair wants cutting,' said the Mouse. '--I proceed. \"Edwin and Morcar, the earls of Mercia and Northumbria, declared.",
                "has_games_news": true,
                "has_fl_marketing": true,
                "has_third_parities": false,
                "user": {
                    "id": 16,
                    "first_name": "Delia",
                    "last_name": "Dietrich",
                    "email": "jackson.swaniawski@example.org",
                    "username": null,
                    "status": "Active",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 64,
            "name": "Catalina Scoreless Hyenas",
            "manager_id": 26,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "62c4d8fa-ca13-4606-ad81-b5c8dec50918",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/f1c3bc250734b585601a62f11e78ea2e-thumb.jpg",
            "remaining_budget": 8.4,
            "consumer": {
                "id": 26,
                "user_id": 26,
                "dob": {
                    "date": "2015-03-13 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "7194 Halie Landing Apt. 981",
                "address_2": "Marion Trail",
                "town": "Rauchester",
                "county": "Niger",
                "post_code": "13976",
                "country": "Madagascar",
                "telephone": "379-263-6130",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "RED rose-tree, and we put a white one in by mistake; and if the Mock Turtle, 'they--you've seen them, of course?' 'Yes,' said Alice very meekly: 'I'm growing.' 'You've no right to think,' said Alice indignantly, and she grew.",
                "has_games_news": true,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 26,
                    "first_name": "Briana",
                    "last_name": "Braun",
                    "email": "adams.barrett@example.org",
                    "username": null,
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-03-20 04:03:23.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 65,
            "name": "Serenity Bizarre Butchers",
            "manager_id": 6,
            "crest_id": 3,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "1abcc100-35ad-44ed-ae6a-25f24caeb87d",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/201dee3f1714ba211d43fea6d0f529cb-thumb.jpg",
            "remaining_budget": 3.2,
            "consumer": {
                "id": 6,
                "user_id": 6,
                "dob": {
                    "date": "2008-08-29 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "68374 Georgianna Mountain Apt. 824",
                "address_2": "Darlene Summit",
                "town": "Port Delores",
                "county": "Oman",
                "post_code": "90101",
                "country": "Indonesia",
                "telephone": "772.671.6709 x179",
                "country_code": "+41",
                "favourite_club": "Chelsea FC",
                "introduction": "At last the Gryphon replied rather impatiently: 'any shrimp could have been changed in the way out of breath, and till the Pigeon the opportunity of adding, 'You're looking for them, but they began moving about again, and went on just as she swam about, trying.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 6,
                    "first_name": "Linda",
                    "last_name": "Altenwerth",
                    "email": "rhiannon14@example.net",
                    "username": null,
                    "status": "Active",
                    "last_login_at": {
                        "date": "2019-03-26 11:20:33.000000",
                        "timezone_type": 3,
                        "timezone": "UTC"
                    }
                }
            }
        },
        {
            "id": 66,
            "name": "Troy Elephants",
            "manager_id": 27,
            "crest_id": 1,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "e9cb5dde-53e2-4bc9-85c9-c82584b4ab14",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 9,
            "consumer": {
                "id": 27,
                "user_id": 27,
                "dob": {
                    "date": "2018-01-26 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "78686 Marty Lodge",
                "address_2": "Cristina Mountains",
                "town": "Port Camdenburgh",
                "county": "Malawi",
                "post_code": "85749-2768",
                "country": "Svalbard & Jan Mayen Islands",
                "telephone": "(324) 870-4409 x92381",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "Queen.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 27,
                    "first_name": "Nakia",
                    "last_name": "Kozey",
                    "email": "jerde.hazle@example.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 67,
            "name": "Claudine Royals",
            "manager_id": 7,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "70f32d08-d17e-41ad-95da-fb0a017e0899",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/f1c3bc250734b585601a62f11e78ea2e-thumb.jpg",
            "remaining_budget": 9.5,
            "consumer": {
                "id": 7,
                "user_id": 7,
                "dob": {
                    "date": "2015-05-23 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "496 Botsford Mall",
                "address_2": "Zella Burgs",
                "town": "New Laurineville",
                "county": "Samoa",
                "post_code": "20707-9413",
                "country": "India",
                "telephone": "+1-474-705-0932",
                "country_code": "+41",
                "favourite_club": "Manchester United",
                "introduction": "Why, I haven't had a little before she found she had made out what it was labelled 'ORANGE MARMALADE', but to get dry again: they had to fall a long breath, and said 'No, never') '--so you can find them.' As she said to Alice, and looking anxiously about her.",
                "has_games_news": false,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 7,
                    "first_name": "Conrad",
                    "last_name": "Jerde",
                    "email": "wrenner@example.com",
                    "username": null,
                    "status": "Active",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 68,
            "name": "Javonte Paper Porcupines",
            "manager_id": 4,
            "crest_id": 3,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "086506a2-5a44-4801-9266-4abecd914129",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/201dee3f1714ba211d43fea6d0f529cb-thumb.jpg",
            "remaining_budget": 3,
            "consumer": {
                "id": 4,
                "user_id": 4,
                "dob": {
                    "date": "2004-12-03 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "8461 Bauch Prairie",
                "address_2": "Brakus Street",
                "town": "Suzannefort",
                "county": "British Virgin Islands",
                "post_code": "03216",
                "country": "Hungary",
                "telephone": "634-804-6655 x6032",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "Why, it fills the whole cause, and condemn you to get through the wood. 'If it had made. 'He took me for asking!.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 4,
                    "first_name": "Gladyce",
                    "last_name": "Miller",
                    "email": "upfannerstill@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 69,
            "name": "Margarita Enchanting Gang",
            "manager_id": 10,
            "crest_id": 1,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "02adabb9-a0d0-467c-b677-4f480d09929a",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 8.3,
            "consumer": {
                "id": 10,
                "user_id": 10,
                "dob": {
                    "date": "1981-04-25 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "75060 DuBuque Ramp",
                "address_2": "Valentine Vista",
                "town": "Dewayneville",
                "county": "Palau",
                "post_code": "16637",
                "country": "Djibouti",
                "telephone": "+1-390-924-4247",
                "country_code": "+41",
                "favourite_club": "Arsenal",
                "introduction": "Alice; 'all I know all the rest, Between yourself and me.' 'That's the.",
                "has_games_news": true,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 10,
                    "first_name": "Ansel",
                    "last_name": "Hirthe",
                    "email": "schiller.lela@example.com",
                    "username": null,
                    "status": "Active",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 70,
            "name": "Josie Scoreless Hyenas",
            "manager_id": 24,
            "crest_id": 3,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "6945c21d-9d54-47d6-998c-927d18b28628",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/3/conversions/201dee3f1714ba211d43fea6d0f529cb-thumb.jpg",
            "remaining_budget": 8.9,
            "consumer": {
                "id": 24,
                "user_id": 24,
                "dob": {
                    "date": "2002-06-07 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "3033 Meghan Ridge Suite 597",
                "address_2": "Lebsack Shores",
                "town": "West Camillaburgh",
                "county": "Brunei Darussalam",
                "post_code": "85374",
                "country": "South Africa",
                "telephone": "+16694136928",
                "country_code": "+41",
                "favourite_club": "Arsenal",
                "introduction": "I think.' And she went on, 'that they'd let Dinah stop in the distance would take the hint; but the tops of the hall: in fact she was.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": true,
                "user": {
                    "id": 24,
                    "first_name": "Vilma",
                    "last_name": "Davis",
                    "email": "johnson.anibal@example.net",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 71,
            "name": "Bria Enchanting Gang",
            "manager_id": 1,
            "crest_id": 1,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "b0c5a6dd-5aa8-4110-9758-a88047c5cbe7",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/1/conversions/319e519037cb5a21ec7da6c4c600f8e1-thumb.jpg",
            "remaining_budget": 4.3,
            "consumer": {
                "id": 1,
                "user_id": 1,
                "dob": {
                    "date": "1977-05-24 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "81036 Aron Ville",
                "address_2": "Meggie Locks",
                "town": "Spencertown",
                "county": "Israel",
                "post_code": "35982-9004",
                "country": "Faroe Islands",
                "telephone": "1-948-545-5626 x481",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "Alice; 'you needn't be so proud as all that.' 'Well.",
                "has_games_news": false,
                "has_fl_marketing": false,
                "has_third_parities": false,
                "user": {
                    "id": 1,
                    "first_name": "Ruchit",
                    "last_name": "Patel",
                    "email": "rpatel@aecordigital.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        },
        {
            "id": 72,
            "name": "Tony Rag Gentlemen",
            "manager_id": 13,
            "crest_id": 4,
            "pitch_id": null,
            "is_approved": true,
            "uuid": "6b27c3e2-1b3d-4487-922b-ff7e76e9a05e",
            "crest_url": "https://fantasyleague-dev.s3.amazonaws.com/4/conversions/f1c3bc250734b585601a62f11e78ea2e-thumb.jpg",
            "remaining_budget": 6.6,
            "consumer": {
                "id": 13,
                "user_id": 13,
                "dob": {
                    "date": "1987-08-05 00:00:00.000000",
                    "timezone_type": 3,
                    "timezone": "UTC"
                },
                "address_1": "3680 Dannie Ways",
                "address_2": "O'Connell Radial",
                "town": "South Darrelton",
                "county": "Lesotho",
                "post_code": "50155-8801",
                "country": "Svalbard & Jan Mayen Islands",
                "telephone": "+1-729-276-4274",
                "country_code": "+41",
                "favourite_club": "Liverpool",
                "introduction": "You gave us three or more; They all sat down at her with large.",
                "has_games_news": false,
                "has_fl_marketing": true,
                "has_third_parities": true,
                "user": {
                    "id": 13,
                    "first_name": "Cortez",
                    "last_name": "Funk",
                    "email": "ottilie.lindgren@example.com",
                    "username": null,
                    "status": "Suspended",
                    "last_login_at": null
                }
            }
        }
    ],
    "gameweeks": [
        {
            "id": 36,
            "number": "36",
            "is_valid_cup_round": true,
            "start": {
                "date": "2019-04-09 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end": {
                "date": "2019-04-16 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 37,
            "number": "37",
            "is_valid_cup_round": false,
            "start": {
                "date": "2019-04-16 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end": {
                "date": "2019-04-23 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 38,
            "number": "38",
            "is_valid_cup_round": true,
            "start": {
                "date": "2019-04-23 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end": {
                "date": "2019-04-30 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 39,
            "number": "39",
            "is_valid_cup_round": true,
            "start": {
                "date": "2019-04-30 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end": {
                "date": "2019-05-07 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 40,
            "number": "40",
            "is_valid_cup_round": true,
            "start": {
                "date": "2019-05-07 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end": {
                "date": "2019-05-14 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        },
        {
            "id": 41,
            "number": "41",
            "is_valid_cup_round": false,
            "start": {
                "date": "2019-05-14 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "end": {
                "date": "2019-09-01 00:00:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
    ]
}
```
