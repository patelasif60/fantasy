- [Seasons](#seasons)
- [Players List](#players_list)
- [Insout list](#insout_list)
- [Players history list](#history_list)
- [Injuries & Suspensions list](#injuries_suspensions_list)

<a name="seasons"></a>
## Seasons List

This api will list down all seasons.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/more/seasons`|`Bearer Token`|

### Success response

```json
{
    "seasons": {
        "30": "2019 - 2020",
        "29": "2018 - 2019",
        "28": "2017 - 2018",
        "27": "2016 - 2017",
        "26": "2015 - 2016",
        "25": "2014 - 2015",
        "24": "2013 - 2014",
        "23": "2012 - 2013",
        "22": "2011 - 2012",
        "21": "2010 - 2011",
        "20": "2009 - 2010",
        "19": "2008 - 2009",
        "18": "2007 - 2008",
        "17": "2006 - 2007",
        "16": "2005 - 2006",
        "15": "2004 - 2005",
        "14": "2003 - 2004",
        "13": "2002 - 2003",
        "12": "2001 - 2002",
        "11": "2000 - 2001",
        "10": "1999 - 2000",
        "9": "1998 - 1999",
        "8": "1997 - 1998",
        "7": "1996 - 1997",
        "6": "1995 - 1996",
        "5": "1994 - 1995",
        "4": "1993 - 1994",
        "3": "1992 - 1993",
        "2": "1991 - 1992",
        "1": "1990 - 1991"
    }
}
```




<a name="players_list"></a>
## Players List

This api will list down all players as in stats tab

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/more/players/{division}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`position`|`text`|`valid position`|Ex: `Goalkeeper (GK)`
|`club`|`integer`|`valid numeric club id`|Ex: `1`
|`start`|`integer`|`required`|Ex:`0,100,200`|`This is pagination offset of next records`|
|`length`|`integer`|`required`|Ex:`100`|`Num of records require`|

Possible positions are 
- Goalkeepers (GK)
- Full-backs (FB)
- Centre-backs (CB)
- Midfielders (MF)
- Strikers (ST)

### Success response

```json
{
    "draw": 0,
    "recordsTotal": 541,
    "recordsFiltered": 541,
    "data": [
        {
            "id": "1",
            "player_first_name": "Mark",
            "player_last_name": "Travers",
            "club_id": "1",
            "club_name": "BOU",
            "player_status": null,
            "player_status_description": null,
            "position": "<div class=\"player-wrapper js-player-details cursor-pointer\" data-id=\"1\" data-name=\"Mark Travers\" data-club=\"BOU\"><div><span class=\"custom-badge custom-badge-lg is-square is-gk\">GK</span></div><div> <div class=\"player-tshirt icon-18 bou_gk mr-1\"></div>M. Travers  </div>",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "bid": null,
            "short_code": "BOU",
            "team_player_contract_id": null,
            "total_goal": null,
            "total_assist": null,
            "total_goal_against": null,
            "total_clean_sheet": null,
            "total_game_played": "0",
            "total_own_goal": null,
            "total_red_card": null,
            "total_yellow_card": null,
            "total_penalty_missed": null,
            "total_penalty_saved": null,
            "total_goalkeeper_save": null,
            "total_club_win": null,
            "weekPoint": 0,
            "monthPoint": 0,
            "total": 0,
            "original_position": "GK",
            "positionOrder": "1",
            "team_manager_name": "<div class=\"player-wrapper\"><div><div></div><div class=\"small\"> </div></div></div>"
        },
        {
            "id": "4",
            "player_first_name": "Tyrone",
            "player_last_name": "Mings",
            "club_id": "48",
            "club_name": "AV",
            "player_status": null,
            "player_status_description": null,
            "position": "<div class=\"player-wrapper js-player-details cursor-pointer\" data-id=\"4\" data-name=\"Tyrone Mings\" data-club=\"AV\"><div><span class=\"custom-badge custom-badge-lg is-square is-cb\">CB</span></div><div> <div class=\"player-tshirt icon-18 av_player mr-1\"></div>T. Mings  </div>",
            "team_id": null,
            "team_name": null,
            "user_first_name": null,
            "user_last_name": null,
            "bid": null,
            "short_code": "AV",
            "team_player_contract_id": null,
            "total_goal": "1",
            "total_assist": "1",
            "total_goal_against": "24",
            "total_clean_sheet": "3",
            "total_game_played": "15",
            "total_own_goal": 0,
            "total_red_card": 0,
            "total_yellow_card": 0,
            "total_penalty_missed": 0,
            "total_penalty_saved": 0,
            "total_goalkeeper_save": 0,
            "total_club_win": 0,
            "weekPoint": "-1",
            "monthPoint": "1",
            "total": "2",
            "original_position": "CB",
            "positionOrder": "3",
            "team_manager_name": "<div class=\"player-wrapper\"><div><div></div><div class=\"small\"> </div></div></div>"
        },
        .
        .
        .
    }
}
```



<a name="insout_list"></a>
## Insout List

This api will list down all players insout as in stats tab

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/more/insout/{division}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`position`|`text`|`valid position`|Ex: `Goalkeeper (GK)`
|`club`|`integer`|`valid numeric club id`|Ex: `1`
|`start`|`integer`|`required`|Ex:`0,100,200`|`This is pagination offset of next records`|
|`length`|`integer`|`required`|Ex:`100`|`Num of records require`|

Possible positions are 
- Goalkeepers (GK)
- Full-backs (FB)
- Centre-backs (CB)
- Midfielders (MF)
- Strikers (ST)

### Success response

```json
{
    "draw": 0,
    "recordsTotal": 16,
    "recordsFiltered": 16,
    "data": [
        {
            "is_active": 0,
            "club_id": "2",
            "id": "5074",
            "player_id": "58",
            "first_name": "Nacho",
            "last_name": "Monreal",
            "short_code": "ARS",
            "start_date": "2019-11-18",
            "position": "FB",
            "end_date": null,
            "outfrom": "Arsenal",
            "outshortcode": "ars",
            "infrom": "Arsenal",
            "inshortcode": "ars",
            "TransferDate": "18/11/2019",
            "player": "N. Monreal",
            "dtstr": "1574035200"
        },
        {
            "is_active": "1",
            "club_id": "6",
            "id": "5071",
            "player_id": "706",
            "first_name": "Reece",
            "last_name": "James",
            "short_code": "CHE",
            "start_date": "2019-11-09",
            "position": "FB",
            "end_date": null,
            "outfrom": "Chelsea",
            "outshortcode": "che",
            "infrom": "Chelsea",
            "inshortcode": "che",
            "TransferDate": "09/11/2019",
            "player": "R. James",
            "dtstr": "1573257600"
        },
        .
        .
        .
    }
}
```



<a name="history_list"></a>
## History List

This api will list down all players history as in stats tab

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/more/history/{division}`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`position`|`text`|`valid position`|Ex: `Goalkeeper (GK)`
|`club`|`integer`|`valid numeric club id`|Ex: `1`
|`start`|`integer`|`required`|Ex:`0,100,200`|`This is pagination offset of next records`|
|`length`|`integer`|`required`|Ex:`100`|`Num of records require`|

Possible positions are 
- Goalkeepers (GK)
- Full-backs (FB)
- Centre-backs (CB)
- Midfielders (MF)
- Strikers (ST)

### Success response

```json
{
    "draw": 0,
    "recordsTotal": 1599,
    "recordsFiltered": 1599,
    "data": [
        {
            "short_name": "Liverpool",
            "short_code": "LIV",
            "goal": "32",
            "assist": "12",
            "goal_conceded": 0,
            "clean_sheet": 0,
            "appearance": 0,
            "played": "34",
            "last_name": "Salah",
            "first_name": "Mohamed",
            "sname": "2017 - 2018",
            "cname": "Liverpool",
            "position": "MF",
            "pid": "380",
            "player": "M. Salah",
            "clubs": "Liverpool",
            "clubs_short_code": "liv",
            "Season": "2017 - 2018",
            "total": "120"
        },
        {
            "short_name": "Tottenham",
            "short_code": "TOT",
            "goal": "29",
            "assist": "7",
            "goal_conceded": 0,
            "clean_sheet": 0,
            "appearance": 0,
            "played": "29",
            "last_name": "Kane",
            "first_name": "Harry",
            "sname": "2016 - 2017",
            "cname": "Tottenham Hotspur",
            "position": "ST",
            "pid": "565",
            "player": "H. Kane",
            "clubs": "Tottenham Hotspur",
            "clubs_short_code": "tot",
            "Season": "2016 - 2017",
            "total": "101"
        },
        .
        .
        .
    }
}
```



<a name="injuries_suspensions_list"></a>
## Injuries & Suspensions List

This api will list down all players Injuries & Suspensions as in stats tab

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/{division}/player/injuries/suspensions`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`division`|`integer`|`valid numeric division id`|Ex: `1`

### Data Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`start`|`integer`|`required`|Ex:`0,100,200`|`This is pagination offset of next records`|
|`length`|`integer`|`required`|Ex:`100`|`Num of records require`|

### Success response

```json
{
    "draw": 0,
    "recordsTotal": 73,
    "recordsFiltered": 73,
    "data": [
        {
            "id": "298",
            "player_id": "672",
            "status": "Injured",
            "description": null,
            "start_date": "2019-11-13",
            "end_date": "19/12/2019",
            "first_name": "Jed",
            "surname": "Steer",
            "name": "Aston Villa",
            "short_name": "Aston Villa",
            "club": "AV",
            "position": "<div class=\"player-wrapper js-player-details cursor-pointer min-width-auto\" data-id=\"298\" data-name=\"Jed Steer\" data-club=\"\"><div><span class=\"custom-badge custom-badge-lg is-square is-gk\">GK</span></div><div>",
            "player": "<div class=\"player-tshirt icon-18 av_gk mr-1\"></div>J. Steer <img src=\"/assets/frontend/img/status/injured.svg\" draggable=\"false\" title=\"\" class=\"status-img ml-2\"> </div>",
            "srank": "1",
            "year": "2019",
            "month": "12",
            "day": "19",
            "positionOrder": "1",
            "m_position": "GK",
            "m_status_img": "https://fantasyleague.com/assets/frontend/img/status/injured.svg",
            "m_tshirt_img": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/AV/player.png"
        },
        {
            "id": "229",
            "player_id": "573",
            "status": "Injured",
            "description": null,
            "start_date": "2019-10-05",
            "end_date": "31/12/2019",
            "first_name": "Hugo",
            "surname": "Lloris",
            "name": "Tottenham Hotspur",
            "short_name": "Tottenham",
            "club": "TOT",
            "position": "<div class=\"player-wrapper js-player-details cursor-pointer min-width-auto\" data-id=\"229\" data-name=\"Hugo Lloris\" data-club=\"\"><div><span class=\"custom-badge custom-badge-lg is-square is-gk\">GK</span></div><div>",
            "player": "<div class=\"player-tshirt icon-18 tot_gk mr-1\"></div>H. Lloris <img src=\"/assets/frontend/img/status/injured.svg\" draggable=\"false\" title=\"\" class=\"status-img ml-2\"> </div>",
            "srank": "1",
            "year": "2019",
            "month": "12",
            "day": "31",
            "positionOrder": "1",
            "m_position": "GK",
            "m_status_img": "https://fantasyleague.com/assets/frontend/img/status/injured.svg",
            "m_tshirt_img": "https://fantasyleague-dev.s3.amazonaws.com/tshirts/TOT/player.png"
        },
        .
        .
        .
    }
}
```