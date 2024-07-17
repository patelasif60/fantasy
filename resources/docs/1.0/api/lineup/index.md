# Team API Docs

---

- [Lineup](#lineup)
- [Team Players Stats](#team_players_stats)
- [Player Stats by Season](#player_stats_by_season)
- [Player History Stats](#player_history_stats)
- [Swap team players](#swap_players)
- [Fixture active players](#fixture_active_players)
- [Check supersub data available for team](#supersub_check)
- [Save supersub data for fixture date](#save_supersub_data)
- [Delete supersub data for fixture date](#delete_supersub_data)
- [Check next fixture data has been updated or not](#check_next_fixture_data)
- [Clubs' matches for fixture date in modal](#clubs_for_fixtures)

----
<a name="lineup"></a>
## Team lineup

This will provide team lineup of players (active players and substitute players).

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/teams/{team}/lineup`|`Bearer Token`|

### URL Params

|Param|Type|Values|Example
|:-|:-|:-|:-
|`team`|`integer`|`required`|Ex: `15`

> {success} Success Response

Code `200`

Content

```json
{
   "activePlayers":{
      "gk":[
         {
            "pld":0,
            "team_id":95,
            "player_id":307,
            "position":"GK",
            "player_first_name":"Ben",
            "player_last_name":"Hamer",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":10,
            "club_name":"Huddersfield Town",
            "short_code":"HUD",
            "team_name":"Ida Scoreless Hyenas",
            "total":0,
            "player_goals":null,
            "player_assists":null,
            "player_conceded":null,
            "player_clean_sheet":null,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Huddersfield",
               "short_name":"Man Utd",
               "short_code":"MUN",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":0,
            "facup_prev":0,
            "facup_total":0,
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/HUD\/GK.png"
         }
      ],
      "df":[
         {
            "pld":0,
            "team_id":95,
            "player_id":42,
            "position":"DF",
            "player_first_name":"Jordi",
            "player_last_name":"Osei-Tutu",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":2,
            "club_name":"Arsenal",
            "short_code":"ARS",
            "team_name":"Ida Scoreless Hyenas",
            "total":0,
            "player_goals":null,
            "player_assists":null,
            "player_conceded":null,
            "player_clean_sheet":null,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Arsenal",
               "short_name":"Leicester",
               "short_code":"LEI",
               "date_time":"2019-04-29 19:00:00",
               "date":"29\/04",
               "time":"20:00",
               "str_date":"29-Apr"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":0,
            "facup_prev":0,
            "facup_total":0,
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/ARS\/player.png"
         },
         {
            "pld":12,
            "team_id":95,
            "player_id":444,
            "position":"DF",
            "player_first_name":"Phil",
            "player_last_name":"Jones",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":14,
            "club_name":"Manchester United",
            "short_code":"MUN",
            "team_name":"Ida Scoreless Hyenas",
            "total":71,
            "player_goals":"0",
            "player_assists":"1",
            "player_conceded":"6",
            "player_clean_sheet":"2",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Man Utd",
               "short_name":"Huddersfield",
               "short_code":"HUD",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":"71",
            "facup_prev":0,
            "facup_total":"0",
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/MUN\/player.png"
         },
         {
            "pld":0,
            "team_id":95,
            "player_id":329,
            "position":"DF",
            "player_first_name":"Terence",
            "player_last_name":"Kongolo",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":10,
            "club_name":"Huddersfield Town",
            "short_code":"HUD",
            "team_name":"Ida Scoreless Hyenas",
            "total":0,
            "player_goals":null,
            "player_assists":null,
            "player_conceded":null,
            "player_clean_sheet":null,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Huddersfield",
               "short_name":"Man Utd",
               "short_code":"MUN",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":0,
            "facup_prev":0,
            "facup_total":0,
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/HUD\/player.png"
         },
         {
            "pld":20,
            "team_id":95,
            "player_id":343,
            "position":"DF",
            "player_first_name":"Wes",
            "player_last_name":"Morgan",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":11,
            "club_name":"Leicester City",
            "short_code":"LEI",
            "team_name":"Ida Scoreless Hyenas",
            "total":126,
            "player_goals":"0",
            "player_assists":"0",
            "player_conceded":"19",
            "player_clean_sheet":"3",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Leicester",
               "short_name":"Arsenal",
               "short_code":"ARS",
               "date_time":"2019-04-29 19:00:00",
               "date":"29\/04",
               "time":"20:00",
               "str_date":"29-Apr"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":"120",
            "facup_prev":0,
            "facup_total":"6",
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/LEI\/player.png"
         }
      ],
      "mf":[
         {
            "pld":0,
            "team_id":95,
            "player_id":403,
            "position":"MF",
            "player_first_name":"Ante",
            "player_last_name":"Palaversa",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":13,
            "club_name":"Manchester City",
            "short_code":"MCI",
            "team_name":"Ida Scoreless Hyenas",
            "total":0,
            "player_goals":null,
            "player_assists":null,
            "player_conceded":null,
            "player_clean_sheet":null,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Man City",
               "short_name":"Leicester",
               "short_code":"LEI",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":0,
            "facup_prev":0,
            "facup_total":0,
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/MCI\/player.png",
            "curr_position":"MF"
         },
         {
            "pld":19,
            "team_id":95,
            "player_id":146,
            "position":"DM",
            "player_first_name":"Joe",
            "player_last_name":"Ralls",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":5,
            "club_name":"Cardiff City",
            "short_code":"CAR",
            "team_name":"Ida Scoreless Hyenas",
            "total":0,
            "player_goals":"0",
            "player_assists":"0",
            "player_conceded":"27",
            "player_clean_sheet":"3",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Cardiff",
               "short_name":"Crystal Palace",
               "short_code":"CRY",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":"0",
            "facup_prev":0,
            "facup_total":0,
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CAR\/player.png",
            "curr_position":"DM"
         },
         {
            "pld":24,
            "team_id":95,
            "player_id":69,
            "position":"MF",
            "player_first_name":"Yves",
            "player_last_name":"Bissouma",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":3,
            "club_name":"Brighton & Hove Albion",
            "short_code":"BRI",
            "team_name":"Ida Scoreless Hyenas",
            "total":90,
            "player_goals":"0",
            "player_assists":"1",
            "player_conceded":"16",
            "player_clean_sheet":"2",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Brighton",
               "short_name":"Arsenal",
               "short_code":"ARS",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":"60",
            "facup_prev":0,
            "facup_total":"30",
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/BRI\/player.png",
            "curr_position":"MF"
         }
      ],
      "st":[
         {
            "pld":22,
            "team_id":95,
            "player_id":448,
            "position":"ST",
            "player_first_name":"Marcus",
            "player_last_name":"Rashford",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":14,
            "club_name":"Manchester United",
            "short_code":"MUN",
            "team_name":"Ida Scoreless Hyenas",
            "total":308,
            "player_goals":"6",
            "player_assists":"4",
            "player_conceded":"17",
            "player_clean_sheet":"2",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Man Utd",
               "short_name":"Huddersfield",
               "short_code":"HUD",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":"301",
            "facup_prev":0,
            "facup_total":"7",
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/MUN\/player.png"
         },
         {
            "pld":1,
            "team_id":95,
            "player_id":107,
            "position":"ST",
            "player_first_name":"Nahki",
            "player_last_name":"Wells",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":4,
            "club_name":"Burnley",
            "short_code":"BUR",
            "team_name":"Ida Scoreless Hyenas",
            "total":14,
            "player_goals":"0",
            "player_assists":"0",
            "player_conceded":"1",
            "player_clean_sheet":"0",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Burnley",
               "short_name":"Everton",
               "short_code":"EVE",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":0,
            "facup_prev":0,
            "facup_total":"14",
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/BUR\/player.png"
         },
         {
            "pld":5,
            "team_id":95,
            "player_id":577,
            "position":"ST",
            "player_first_name":"Stefano",
            "player_last_name":"Okaka Chuka",
            "user_first_name":"Matt",
            "user_last_name":"Sims",
            "club_id":18,
            "club_name":"Watford",
            "short_code":"WAT",
            "team_name":"Ida Scoreless Hyenas",
            "total":7,
            "player_goals":"0",
            "player_assists":"0",
            "player_conceded":"0",
            "player_clean_sheet":"0",
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Watford",
               "short_name":"Chelsea",
               "short_code":"CHE",
               "date_time":"2019-05-04 14:00:00",
               "date":"04\/05",
               "time":"15:00",
               "str_date":"04-May"
            },
            "month_total2":0,
            "week_total2":0,
            "current_week":0,
            "week_total":"7",
            "facup_prev":0,
            "facup_total":0,
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/WAT\/player.png"
         }
      ]
   },
   "subPlayers":[
      {
         "pld":0,
         "team_id":95,
         "player_id":213,
         "position":"ST",
         "player_first_name":"Alexander",
         "player_last_name":"S\u00f8rloth",
         "user_first_name":"Matt",
         "user_last_name":"Sims",
         "club_id":7,
         "club_name":"Crystal Palace",
         "short_code":"CRY",
         "team_name":"Ida Scoreless Hyenas",
         "total":0,
         "player_goals":null,
         "player_assists":null,
         "player_conceded":null,
         "player_clean_sheet":null,
         "is_processed":0,
         "has_next_fixture":0,
         "status":null,
         "current_week":0,
         "week_total":0,
         "facup_prev":0,
         "facup_total":0,
         "next_fixture":{
            "type":"A",
            "club":"Crystal Palace",
            "short_name":"Cardiff",
            "short_code":"CAR",
            "date_time":"2019-05-04 14:00:00",
            "date":"04\/05",
            "time":"15:00",
            "str_date":"04-May"
         },
         "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CRY\/player.png",
         "month_total2":0,
         "week_total2":0
      },
      {
         "pld":17,
         "team_id":95,
         "player_id":167,
         "position":"DF",
         "player_first_name":"Andreas",
         "player_last_name":"Christensen",
         "user_first_name":"Matt",
         "user_last_name":"Sims",
         "club_id":6,
         "club_name":"Chelsea",
         "short_code":"CHE",
         "team_name":"Ida Scoreless Hyenas",
         "total":47,
         "player_goals":"0",
         "player_assists":"1",
         "player_conceded":"3",
         "player_clean_sheet":"1",
         "is_processed":0,
         "has_next_fixture":0,
         "status":null,
         "current_week":0,
         "week_total":"24",
         "facup_prev":0,
         "facup_total":"23",
         "next_fixture":{
            "type":"H",
            "club":"Chelsea",
            "short_name":"Watford",
            "short_code":"WAT",
            "date_time":"2019-05-04 14:00:00",
            "date":"04\/05",
            "time":"15:00",
            "str_date":"04-May"
         },
         "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CHE\/player.png",
         "month_total2":0,
         "week_total2":0
      },
      {
         "pld":15,
         "team_id":95,
         "player_id":33,
         "position":"MF",
         "player_first_name":"Henrikh",
         "player_last_name":"Mkhitaryan",
         "user_first_name":"Matt",
         "user_last_name":"Sims",
         "club_id":2,
         "club_name":"Arsenal",
         "short_code":"ARS",
         "team_name":"Ida Scoreless Hyenas",
         "total":68,
         "player_goals":"3",
         "player_assists":"3",
         "player_conceded":"13",
         "player_clean_sheet":"1",
         "is_processed":0,
         "has_next_fixture":0,
         "status":null,
         "current_week":0,
         "week_total":"68",
         "facup_prev":0,
         "facup_total":0,
         "next_fixture":{
            "type":"A",
            "club":"Arsenal",
            "short_name":"Leicester",
            "short_code":"LEI",
            "date_time":"2019-04-29 19:00:00",
            "date":"29\/04",
            "time":"20:00",
            "str_date":"29-Apr"
         },
         "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/ARS\/player.png",
         "month_total2":0,
         "week_total2":0
      },
      {
         "pld":8,
         "team_id":95,
         "player_id":74,
         "position":"GK",
         "player_first_name":"Jason",
         "player_last_name":"Steele",
         "user_first_name":"Matt",
         "user_last_name":"Sims",
         "club_id":3,
         "club_name":"Brighton & Hove Albion",
         "short_code":"BRI",
         "team_name":"Ida Scoreless Hyenas",
         "total":0,
         "player_goals":"0",
         "player_assists":"0",
         "player_conceded":"0",
         "player_clean_sheet":"0",
         "is_processed":0,
         "has_next_fixture":0,
         "status":null,
         "current_week":0,
         "week_total":"0",
         "facup_prev":0,
         "facup_total":0,
         "next_fixture":{
            "type":"A",
            "club":"Brighton",
            "short_name":"Arsenal",
            "short_code":"ARS",
            "date_time":"2019-05-04 14:00:00",
            "date":"04\/05",
            "time":"15:00",
            "str_date":"04-May"
         },
         "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/BRI\/GK.png",
         "month_total2":0,
         "week_total2":0
      },
      {
         "pld":0,
         "team_id":95,
         "player_id":145,
         "position":"MF",
         "player_first_name":"Josh",
         "player_last_name":"Murphy",
         "user_first_name":"Matt",
         "user_last_name":"Sims",
         "club_id":5,
         "club_name":"Cardiff City",
         "short_code":"CAR",
         "team_name":"Ida Scoreless Hyenas",
         "total":0,
         "player_goals":null,
         "player_assists":null,
         "player_conceded":null,
         "player_clean_sheet":null,
         "is_processed":0,
         "has_next_fixture":0,
         "status":null,
         "current_week":0,
         "week_total":0,
         "facup_prev":0,
         "facup_total":0,
         "next_fixture":{
            "type":"H",
            "club":"Cardiff",
            "short_name":"Crystal Palace",
            "short_code":"CRY",
            "date_time":"2019-05-04 14:00:00",
            "date":"04\/05",
            "time":"15:00",
            "str_date":"04-May"
         },
         "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CAR\/player.png",
         "month_total2":0,
         "week_total2":0
      },
      {
         "pld":0,
         "team_id":95,
         "player_id":206,
         "position":"DF",
         "player_first_name":"Ryan",
         "player_last_name":"Inniss",
         "user_first_name":"Matt",
         "user_last_name":"Sims",
         "club_id":7,
         "club_name":"Crystal Palace",
         "short_code":"CRY",
         "team_name":"Ida Scoreless Hyenas",
         "total":0,
         "player_goals":null,
         "player_assists":null,
         "player_conceded":null,
         "player_clean_sheet":null,
         "is_processed":0,
         "has_next_fixture":0,
         "status":null,
         "current_week":0,
         "week_total":0,
         "facup_prev":0,
         "facup_total":0,
         "next_fixture":{
            "type":"A",
            "club":"Crystal Palace",
            "short_name":"Cardiff",
            "short_code":"CAR",
            "date_time":"2019-05-04 14:00:00",
            "date":"04\/05",
            "time":"15:00",
            "str_date":"04-May"
         },
         "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CRY\/player.png",
         "month_total2":0,
         "week_total2":0
      }
   ],
   "pitch":"http:\/\/farzan-fantasyleague.dev.aecortech.com\/assets\/frontend\/img\/pitch\/pitch-1.png",
   "availableFormations":[
      "1442",
      "1451",
      "1433",
      "1532",
      "1541"
   ],
   "minMaxNumberForPosition":{
      "fb":{
         "min":2,
         "max":2
      },
      "cb":{
         "min":2,
         "max":3
      },
      "df":{
         "min":"4",
         "max":"5"
      },
      "mf":{
         "min":"3",
         "max":"5"
      },
      "st":{
         "min":"1",
         "max":"3"
      }
   },
   "team_stats":{
      "current_week":0,
      "week_total":"651",
      "facup_prev":"6",
      "facup_total":"80"
   },
   "teamClubs":{
      "2":2,
      "3":3,
      "4":4,
      "5":5,
      "6":6,
      "7":7,
      "10":10,
      "11":11,
      "13":13,
      "14":14,
      "18":18
   },
   "futureFixturesDates":{
      "2019-04-29 19:00:00":{
         "date_time":"2019-04-29 20:00:00",
         "date":"29\/04",
         "time":"20:00"
      },
      "2019-05-04 14:00:00":{
         "date_time":"2019-05-04 15:00:00",
         "date":"04\/05",
         "time":"15:00"
      },
      "2019-05-12 14:00:00":{
         "date_time":"2019-05-12 15:00:00",
         "date":"12\/05",
         "time":"15:00"
      }
   },
   "seasons":{
      "1":"2000 - 2001",
      "2":"2001 - 2002",
      "3":"2002 - 2003",
      "4":"2003 - 2004",
      "5":"2004 - 2005",
      "6":"2005 - 2006",
      "7":"2006 - 2007",
      "8":"2007 - 2008",
      "9":"2008 - 2009",
      "10":"2009 - 2010",
      "11":"2010 - 2011",
      "12":"2011 - 2012",
      "13":"2012 - 2013",
      "14":"2013 - 2014",
      "15":"2014 - 2015",
      "16":"2015 - 2016",
      "17":"2016 - 2017",
      "18":"2017 - 2018",
      "19":"2018 - 2019"
   },
   "currentSeason":19,
   "playerSeasonStats":{
      "33":{
         "player_id":33,
         "position":"Midfielder (MF)",
         "pld":15,
         "gls":"3",
         "asst":"3",
         "ga":"13",
         "cs":"1",
         "app":"9",
         "club_win":"5",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"1",
         "total":68
      },
      "69":{
         "player_id":69,
         "position":"Midfielder (MF)",
         "pld":24,
         "gls":"0",
         "asst":"1",
         "ga":"16",
         "cs":"2",
         "app":"11",
         "club_win":"5",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"5",
         "total":90
      },
      "74":{
         "player_id":74,
         "position":"Goalkeeper (GK)",
         "pld":8,
         "gls":"0",
         "asst":"0",
         "ga":"0",
         "cs":"0",
         "app":"0",
         "club_win":"0",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"0",
         "total":0
      },
      "107":{
         "player_id":107,
         "position":"Striker (ST)",
         "pld":1,
         "gls":"0",
         "asst":"0",
         "ga":"1",
         "cs":"0",
         "app":"1",
         "club_win":"0",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"0",
         "total":14
      },
      "145":{
         "player_id":145,
         "position":"Midfielder (MF)",
         "pld":19,
         "gls":"3",
         "asst":"1",
         "ga":"12",
         "cs":"4",
         "app":"11",
         "club_win":"6",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"1",
         "total":94
      },
      "146":{
         "player_id":146,
         "position":"Defensive Midfielder (DMF)",
         "pld":19,
         "gls":"0",
         "asst":"0",
         "ga":"27",
         "cs":"3",
         "app":"15",
         "club_win":"3",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"1",
         "yellow_card":"3",
         "total":118
      },
      "167":{
         "player_id":167,
         "position":"Centre-back (CB)",
         "pld":17,
         "gls":"0",
         "asst":"1",
         "ga":"3",
         "cs":"1",
         "app":"3",
         "club_win":"2",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"1",
         "total":70
      },
      "213":{
         "player_id":213,
         "position":"Striker (ST)",
         "pld":14,
         "gls":"0",
         "asst":"0",
         "ga":"3",
         "cs":"0",
         "app":"1",
         "club_win":"1",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"0",
         "total":29
      },
      "307":{
         "player_id":307,
         "position":"Goalkeeper (GK)",
         "pld":22,
         "gls":"0",
         "asst":"0",
         "ga":"12",
         "cs":"0",
         "app":"4",
         "club_win":"0",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"2.8000",
         "red_card":"0",
         "yellow_card":"0",
         "total":97
      },
      "329":{
         "player_id":329,
         "position":"Centre-back (CB)",
         "pld":19,
         "gls":"1",
         "asst":"0",
         "ga":"26",
         "cs":"3",
         "app":"16",
         "club_win":"3",
         "own_goal":"1",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"3",
         "total":401
      },
      "343":{
         "player_id":343,
         "position":"Centre-back (CB)",
         "pld":20,
         "gls":"0",
         "asst":"0",
         "ga":"19",
         "cs":"3",
         "app":"14",
         "club_win":"3",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"2",
         "yellow_card":"1",
         "total":328
      },
      "444":{
         "player_id":444,
         "position":"Centre-back (CB)",
         "pld":12,
         "gls":"0",
         "asst":"1",
         "ga":"6",
         "cs":"2",
         "app":"6",
         "club_win":"4",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"0",
         "total":128
      },
      "448":{
         "player_id":448,
         "position":"Striker (ST)",
         "pld":22,
         "gls":"6",
         "asst":"4",
         "ga":"17",
         "cs":"2",
         "app":"13",
         "club_win":"8",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"1",
         "yellow_card":"2",
         "total":313
      },
      "577":{
         "player_id":577,
         "position":"Striker (ST)",
         "pld":5,
         "gls":"0",
         "asst":"0",
         "ga":"0",
         "cs":"0",
         "app":"0",
         "club_win":"0",
         "own_goal":"0",
         "penalty_missed":"0",
         "penalty_save":"0",
         "goalkeeper_save":"0.0000",
         "red_card":"0",
         "yellow_card":"1",
         "total":7
      }
   },
   "ownTeam":true
}
```
----
<a name="team_players_stats"></a>
## Get all players stats for a given Team ID

This api will provide Premier League, FA Cup, and Matches stats of all team players.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/player/{team}/stats`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team`|`integer`|`required (Team id)`|Ex: `1`

> {success} Success Response

Code `200`

Content

```json
{
    "3": {
        "id": 3,
        "first_name": "Kyle",
        "last_name": "Taylor",
        "image": "https://via.placeholder.com/640x307/333357/333357",
        "position": "MF",
        "status": null,
        "club": {
            "id": 1,
            "name": "AFC Bournemouth",
            "api_id": "1pse9ta7a45pi2w2grjim70ge",
            "short_name": "Bournemouth",
            "short_code": "BOR",
            "is_premier": true,
            "created_at": "2019-03-12 05:31:14",
            "updated_at": "2019-03-12 05:31:14"
        },
        "game_stats": {
            "point_calculation": {
                "goals": 3,
                "assist": 2,
                "clean_sheet": 0,
                "goal_conceded": 0,
                "appearance": 0,
                "club_win": null,
                "yellow_card": null,
                "red_card": null,
                "own_goal": null,
                "penalty_missed": null,
                "penalty_save": null,
                "goalkeeper_save": null
            },
            "history": []
        }
    },
    "4": {
        "id": 4,
        "first_name": "Tyrone",
        "last_name": "Mings",
        "image": "https://via.placeholder.com/640x307/333357/333357",
        "position": "DF",
        "status": null,
        "club": {
            "id": 1,
            "name": "AFC Bournemouth",
            "api_id": "1pse9ta7a45pi2w2grjim70ge",
            "short_name": "Bournemouth",
            "short_code": "BOR",
            "is_premier": true,
            "created_at": "2019-03-12 05:31:14",
            "updated_at": "2019-03-12 05:31:14"
        },
        "game_stats": {
            "point_calculation": {
                "goals": 3,
                "assist": 2,
                "clean_sheet": 3,
                "goal_conceded": -1,
                "appearance": 1,
                "club_win": null,
                "yellow_card": null,
                "red_card": null,
                "own_goal": null,
                "penalty_missed": null,
                "penalty_save": null,
                "goalkeeper_save": null
            },
            "premier_league": {
                "away": {
                    "player_id": 4,
                    "pld": 5,
                    "gls": "0",
                    "asst": "0",
                    "ga": "0",
                    "cs": "0",
                    "app": "0",
                    "club_win": "0",
                    "own_goal": "0",
                    "penalty_missed": "0",
                    "penalty_save": "0",
                    "goalkeeper_save": "0.0000",
                    "red_card": "0",
                    "yellow_card": "0",
                    "ha": "away",
                    "total": 0
                },
                "home": {
                    "player_id": 4,
                    "pld": 4,
                    "gls": "0",
                    "asst": "0",
                    "ga": "0",
                    "cs": "0",
                    "app": "0",
                    "club_win": "0",
                    "own_goal": "0",
                    "penalty_missed": "0",
                    "penalty_save": "0",
                    "goalkeeper_save": "0.0000",
                    "red_card": "0",
                    "yellow_card": "0",
                    "ha": "home",
                    "total": 0
                }
            },
            "fa_cup": {
                "away": {
                    "player_id": 447,
                    "pld": "4",
                    "gls": "2",
                    "asst": "0",
                    "ga": 0,
                    "cs": 0,
                    "app": "4",
                    "club_win": "1",
                    "own_goal": "0",
                    "penalty_missed": "1",
                    "penalty_save": "0",
                    "goalkeeper_save": "0",
                    "red_card": "0",
                    "yellow_card": "0",
                    "ha": "away",
                    "total": 6
                },
                "home": {
                    "player_id": 447,
                    "pld": "3",
                    "gls": "1",
                    "asst": "3",
                    "ga": 0,
                    "cs": 0,
                    "app": "3",
                    "club_win": "2",
                    "own_goal": "0",
                    "penalty_missed": "0",
                    "penalty_save": "0",
                    "goalkeeper_save": "0",
                    "red_card": "0",
                    "yellow_card": "1",
                    "ha": "home",
                    "total": 9
                }
            },
            "history": {
                "181": {
                    "date": "30/12",
                    "competition": "Premier League",
                    "opp": "MUN(A)",
                    "res": "L(1-4)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 8,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": "out"
                },
                "194": {
                    "date": "26/12",
                    "competition": "Premier League",
                    "opp": "TOT(A)",
                    "res": "L(0-5)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": ""
                },
                "230": {
                    "date": "08/12",
                    "competition": "Premier League",
                    "opp": "LIV(H)",
                    "res": "L(0-4)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 7,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": "out"
                },
                "240": {
                    "date": "04/12",
                    "competition": "Premier League",
                    "opp": "HUD(H)",
                    "res": "W(2-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 1,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": "out"
                },
                "253": {
                    "date": "25/11",
                    "competition": "Premier League",
                    "opp": "ARS(H)",
                    "res": "L(1-2)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": ""
                },
                "329": {
                    "date": "22/09",
                    "competition": "Premier League",
                    "opp": "BUR(A)",
                    "res": "L(0-4)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": ""
                },
                "348": {
                    "date": "01/09",
                    "competition": "Premier League",
                    "opp": "CHE(A)",
                    "res": "L(0-2)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": ""
                },
                "366": {
                    "date": "18/08",
                    "competition": "Premier League",
                    "opp": "WHU(A)",
                    "res": "W(2-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": ""
                },
                "378": {
                    "date": "11/08",
                    "competition": "Premier League",
                    "opp": "CAR(H)",
                    "res": "W(2-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "in_lineup",
                    "is_sub": ""
                }
            }
        }
    },
    .
    .
    .
    .
    .
}
```

----

<a name="player_stats_by_season"></a>
## Player stats by Season

This api will provide you player stats by season.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/{team}/player/{player}/season/{season}/stats`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team`|`integer`|`required (Team id)`|Ex: `65`
|`player`|`integer`|`required (Player id)`|Ex: `253`
|`season`|`integer`|`required (Season id)`|Ex: `19`

> {success} Success Response

Code `200`

Content

```json
{
    "253": {
        "id": 253,
        "first_name": "Ademola",
        "last_name": "Lookman",
        "image": "https://via.placeholder.com/640x307/333357/333357",
        "position": "MF",
        "status": null,
        "club": {
            "id": 8,
            "name": "Everton",
            "api_id": "ehd2iemqmschhj2ec0vayztzz",
            "short_name": "Everton",
            "short_code": "EVE",
            "is_premier": true,
            "created_at": "2019-03-12 05:31:15",
            "updated_at": "2019-03-12 05:31:15"
        },
        "game_stats": {
            "point_calculation": {
                "goals": 2,
                "assist": 2,
                "clean_sheet": 5,
                "goal_conceded": 10,
                "appearance": 4,
                "club_win": 4,
                "yellow_card": 2,
                "red_card": 0,
                "own_goal": 10,
                "penalty_missed": 2,
                "penalty_save": 7,
                "goalkeeper_save": 10
            },
            "premier_league": {
                "away": {
                    "player_id": 253,
                    "pld": 7,
                    "gls": "0",
                    "asst": "0",
                    "ga": "1",
                    "cs": "0",
                    "app": "0",
                    "club_win": "0",
                    "own_goal": "0",
                    "penalty_missed": "0",
                    "penalty_save": "0",
                    "goalkeeper_save": "0.0000",
                    "red_card": "0",
                    "yellow_card": "0",
                    "ha": "away",
                    "total": 10
                },
                "home": {
                    "player_id": 253,
                    "pld": 10,
                    "gls": "0",
                    "asst": "2",
                    "ga": "1",
                    "cs": "1",
                    "app": "2",
                    "club_win": "1",
                    "own_goal": "0",
                    "penalty_missed": "0",
                    "penalty_save": "0",
                    "goalkeeper_save": "0.0000",
                    "red_card": "0",
                    "yellow_card": "0",
                    "ha": "home",
                    "total": 31
                }
            },
            "fa_cup": {
                "away": {
                    "player_id": 253,
                    "pld": 1,
                    "gls": "0",
                    "asst": "0",
                    "ga": "2",
                    "cs": "0",
                    "app": "1",
                    "club_win": "0",
                    "own_goal": "0",
                    "penalty_missed": "0",
                    "penalty_save": "0",
                    "goalkeeper_save": "0.0000",
                    "red_card": "0",
                    "yellow_card": "0",
                    "ha": "away",
                    "total": 24
                },
                "home": {
                    "total": 0
                }
            },
            "history": {
                "86": {
                    "date": "09/03",
                    "competition": "Premier League",
                    "opp": "NEW(A)",
                    "res": "L(2-3)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 8,
                    "assist": 0,
                    "goal": 0,
                    "total": 10,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "110": {
                    "date": "26/02",
                    "competition": "Premier League",
                    "opp": "CAR(A)",
                    "res": "W(3-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 8,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "124": {
                    "date": "09/02",
                    "competition": "Premier League",
                    "opp": "WAT(A)",
                    "res": "L(0-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "148": {
                    "date": "29/01",
                    "competition": "Premier League",
                    "opp": "HUD(A)",
                    "res": "W(1-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "163": {
                    "date": "13/01",
                    "competition": "Premier League",
                    "opp": "BOR(H)",
                    "res": "W(2-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 90,
                    "assist": 1,
                    "goal": 0,
                    "total": 10,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "221": {
                    "date": "10/12",
                    "competition": "Premier League",
                    "opp": "WAT(H)",
                    "res": "D(2-2)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 24,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "233": {
                    "date": "05/12",
                    "competition": "Premier League",
                    "opp": "NEW(H)",
                    "res": "D(1-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 78,
                    "assist": 0,
                    "goal": 0,
                    "total": 10,
                    "player_is": "not_in_team",
                    "is_sub": "in"
                },
                "259": {
                    "date": "24/11",
                    "competition": "Premier League",
                    "opp": "CAR(H)",
                    "res": "W(1-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 17,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "263": {
                    "date": "11/11",
                    "competition": "Premier League",
                    "opp": "CHE(A)",
                    "res": "D(0-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 26,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "278": {
                    "date": "03/11",
                    "competition": "Premier League",
                    "opp": "BRI(H)",
                    "res": "W(3-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 22,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "292": {
                    "date": "21/10",
                    "competition": "Premier League",
                    "opp": "CRY(H)",
                    "res": "W(2-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 8,
                    "assist": 1,
                    "goal": 0,
                    "total": 2,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "307": {
                    "date": "06/10",
                    "competition": "Premier League",
                    "opp": "LEI(A)",
                    "res": "W(2-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "318": {
                    "date": "29/09",
                    "competition": "Premier League",
                    "opp": "FUL(H)",
                    "res": "W(3-0)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "321": {
                    "date": "23/09",
                    "competition": "Premier League",
                    "opp": "ARS(A)",
                    "res": "L(0-2)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "332": {
                    "date": "16/09",
                    "competition": "Premier League",
                    "opp": "WHU(H)",
                    "res": "L(1-3)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 13,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "346": {
                    "date": "01/09",
                    "competition": "Premier League",
                    "opp": "HUD(H)",
                    "res": "D(1-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 33,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": "out"
                },
                "369": {
                    "date": "18/08",
                    "competition": "Premier League",
                    "opp": "SOT(H)",
                    "res": "W(2-1)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 0,
                    "assist": 0,
                    "goal": 0,
                    "total": 0,
                    "player_is": "not_in_team",
                    "is_sub": ""
                },
                "396": {
                    "date": "26/01",
                    "competition": "FA Cup",
                    "opp": "MIL(A)",
                    "res": "L(2-3)",
                    "red_card": 0,
                    "yellow_card": 0,
                    "appearance": 79,
                    "assist": 0,
                    "goal": 0,
                    "total": 20,
                    "player_is": "not_in_team",
                    "is_sub": "in"
                }
            }
        }
    }
}
```
Note: "history" is known as "matches" player already played.

----

<a name="player_history_stats"></a>
## Player history stats

This api will provide you player history stats.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/leagues/{division}/player/history`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`division`|`integer`|`required (Division id)`|Ex: `930`
|`player_id`|`integer`|`required (Player id)`|Ex: `58`

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": [
        {
            "name": "2018 - 2019",
            "played": 20,
            "appearance": 20,
            "goal": 1,
            "assist": 4,
            "clean_sheet": 5,
            "goal_conceded": 24,
            "total": 17
        },
        {
            "name": "2017 - 2018",
            "played": 25,
            "appearance": 25,
            "goal": 5,
            "assist": 2,
            "clean_sheet": 10,
            "goal_conceded": 29,
            "total": 35
        },
        {
            "name": "2016 - 2017",
            "played": 35,
            "appearance": 35,
            "goal": 0,
            "assist": 3,
            "clean_sheet": 11,
            "goal_conceded": 43,
            "total": 20
        },
        {
            "name": "2015 - 2016",
            "played": 36,
            "appearance": 36,
            "goal": 0,
            "assist": 3,
            "clean_sheet": 17,
            "goal_conceded": 34,
            "total": 42
        },
        {
            "name": "2014 - 2015",
            "played": 25,
            "appearance": 25,
            "goal": 0,
            "assist": 2,
            "clean_sheet": 9,
            "goal_conceded": 23,
            "total": 24
        },
        {
            "name": "2013 - 2014",
            "played": 13,
            "appearance": 13,
            "goal": 0,
            "assist": 1,
            "clean_sheet": 7,
            "goal_conceded": 17,
            "total": 12
        },
        {
            "name": "2012 - 2013",
            "played": 9,
            "appearance": 9,
            "goal": 1,
            "assist": 1,
            "clean_sheet": 5,
            "goal_conceded": 5,
            "total": 19
        }
    ]
}
```

----
<a name="swap_players"></a>
## Swap Team Players

This will swap lineup and substitute player vice versa.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/player/swap`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`lineup_player`|`integer`|`required (Lineup player id)`|Ex: `1`
|`sub_player`|`integer`|`required (Substitute player id)`|Ex: `3`
|`team_id`|`integer`|`required (Team id)`|Ex: `5`
|`formation`|`integer`|`required (Valid league team lineup formations)`|Ex: `1532`, `1433`, `1541`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "status": true
    }
}
```

----
<a name="fixture_active_players"></a>
## Fixture Active Players

This will return all active players of team by fixture date.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/fixture/players`|`Bearer Token`|

### Post Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team_id`|`integer`|`required (Team id)`|Ex: `1`
|`date`|`date`|`required (valid date with time)`|Ex: `2019-04-21 12:30:00`

> {success} Success Response

Code `200`

Content

A) User has no data for supersub : 
In this case, we have to use user's team lineup data (as same as "subs" or "squad" data)

```json
{
    "data": {
        "activeClubPlayers": [
            33
         ],
        "fixture_date_count":0,
        "saved_data":0
    }
}
```
Note: 539 is active player id for selected fixture date.

A) User has saved data for supersub

a) if fixture_date_count is 0 then user has not saved data for that fixture date. if fixture_date_count > 0 then user has saved data for fixture date. You can use this to hide/show cancel button / accept and edit button

b) if saved_data = 1 then we have to use "activePlayers" and "subPlayers" from response. if saved_data = 0 then user has no supersub data so we have to use user's team lineup data (as same as "subs" or "squad" data)

```json
{
   "data": {
      "activeClubPlayers":[
         310
      ],
      "fixture_date_count":0,
      "saved_data":1,
      "activePlayers":{
         "gk":[
            {
               "pld":16,
               "team_id":65,
               "player_id":441,
               "position":"GK",
               "player_first_name":"Sergio Germ\u00e1n",
               "player_last_name":"Romero",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":14,
               "club_name":"Manchester United",
               "short_code":"MUN",
               "team_name":"Serenity Bizarre Butchers",
               "total":11,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"H",
                  "club":"Man Utd",
                  "short_name":"Man City",
                  "short_code":"MCI",
                  "date_time":"2019-04-24 19:00:00",
                  "date":"24\/04",
                  "time":"19:00",
                  "str_date":"24-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/MUN\/GK.png"
            }
         ],
         "df":[
            {
               "pld":19,
               "team_id":65,
               "player_id":310,
               "position":"FB",
               "player_first_name":"Erik",
               "player_last_name":"Durm",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":10,
               "club_name":"Huddersfield Town",
               "short_code":"HUD",
               "team_name":"Serenity Bizarre Butchers",
               "total":175,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"A",
                  "club":"Huddersfield",
                  "short_name":"Liverpool",
                  "short_code":"LIV",
                  "date_time":"2019-04-26 19:00:00",
                  "date":"26\/04",
                  "time":"19:00",
                  "str_date":"26-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/HUD\/player.png"
            },
            {
               "pld":0,
               "team_id":65,
               "player_id":574,
               "position":"CB",
               "player_first_name":"Christian",
               "player_last_name":"Kabasele",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":18,
               "club_name":"Watford",
               "short_code":"WAT",
               "team_name":"Serenity Bizarre Butchers",
               "total":0,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"H",
                  "club":"Watford",
                  "short_name":"Wolverhampton",
                  "short_code":"WOL",
                  "date_time":"2019-04-27 14:00:00",
                  "date":"27\/04",
                  "time":"14:00",
                  "str_date":"27-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/WAT\/player.png"
            },
            {
               "pld":0,
               "team_id":65,
               "player_id":13,
               "position":"CB",
               "player_first_name":"Nathan",
               "player_last_name":"Ak\u00e9",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":1,
               "club_name":"AFC Bournemouth",
               "short_code":"BOR",
               "team_name":"Serenity Bizarre Butchers",
               "total":0,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"A",
                  "club":"Bournemouth",
                  "short_name":"Southampton",
                  "short_code":"SOT",
                  "date_time":"2019-04-27 14:00:00",
                  "date":"27\/04",
                  "time":"14:00",
                  "str_date":"27-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/BOR\/player.png"
            },
            {
               "pld":19,
               "team_id":65,
               "player_id":290,
               "position":"CB",
               "player_first_name":"Tim",
               "player_last_name":"Ream",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":9,
               "club_name":"Fulham",
               "short_code":"FUL",
               "team_name":"Serenity Bizarre Butchers",
               "total":166,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"H",
                  "club":"Fulham",
                  "short_name":"Cardiff",
                  "short_code":"CAR",
                  "date_time":"2019-04-27 14:00:00",
                  "date":"27\/04",
                  "time":"14:00",
                  "str_date":"27-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/FUL\/player.png"
            }
         ],
         "mf":[
            {
               "pld":24,
               "team_id":65,
               "player_id":207,
               "position":"MF",
               "player_first_name":"Andros",
               "player_last_name":"Townsend",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":7,
               "club_name":"Crystal Palace",
               "short_code":"CRY",
               "team_name":"Serenity Bizarre Butchers",
               "total":451,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"H",
                  "club":"Crystal Palace",
                  "short_name":"Everton",
                  "short_code":"EVE",
                  "date_time":"2019-04-27 14:00:00",
                  "date":"27\/04",
                  "time":"14:00",
                  "str_date":"27-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CRY\/player.png",
               "curr_position":"MF"
            },
            {
               "pld":6,
               "team_id":65,
               "player_id":177,
               "position":"MF",
               "player_first_name":"Callum",
               "player_last_name":"Hudson-Odoi",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":6,
               "club_name":"Chelsea",
               "short_code":"CHE",
               "team_name":"Serenity Bizarre Butchers",
               "total":25,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"A",
                  "club":"Chelsea",
                  "short_name":"Man Utd",
                  "short_code":"MUN",
                  "date_time":"2019-04-28 15:30:00",
                  "date":"28\/04",
                  "time":"15:30",
                  "str_date":"28-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CHE\/player.png",
               "curr_position":"MF"
            },
            {
               "pld":7,
               "team_id":65,
               "player_id":337,
               "position":"MF",
               "player_first_name":"Harvey Lewis",
               "player_last_name":"Barnes",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":11,
               "club_name":"Leicester City",
               "short_code":"LEI",
               "team_name":"Serenity Bizarre Butchers",
               "total":90,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"H",
                  "club":"Leicester",
                  "short_name":"Arsenal",
                  "short_code":"ARS",
                  "date_time":"2019-04-29 19:00:00",
                  "date":"29\/04",
                  "time":"19:00",
                  "str_date":"29-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/LEI\/player.png",
               "curr_position":"MF"
            },
            {
               "pld":0,
               "team_id":65,
               "player_id":406,
               "position":"MF",
               "player_first_name":"Ian",
               "player_last_name":"Poveda",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":13,
               "club_name":"Manchester City",
               "short_code":"MCI",
               "team_name":"Serenity Bizarre Butchers",
               "total":0,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"A",
                  "club":"Man City",
                  "short_name":"Man Utd",
                  "short_code":"MUN",
                  "date_time":"2019-04-24 19:00:00",
                  "date":"24\/04",
                  "time":"19:00",
                  "str_date":"24-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/MCI\/player.png",
               "curr_position":"MF"
            }
         ],
         "st":[
            {
               "pld":19,
               "team_id":65,
               "player_id":543,
               "position":"ST",
               "player_first_name":"Fernando",
               "player_last_name":"Llorente Torres",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":17,
               "club_name":"Tottenham Hotspur",
               "short_code":"TOT",
               "team_name":"Serenity Bizarre Butchers",
               "total":126,
               "is_processed":0,
               "has_next_fixture":0,
               "status":{
                  "id":2,
                  "player_id":543,
                  "status":"Doubtful",
                  "description":"Doubtful",
                  "start_date":"2019-03-28",
                  "end_date":"2019-04-27",
                  "created_at":null,
                  "updated_at":null
               },
               "next_fixture":{
                  "type":"H",
                  "club":"Tottenham",
                  "short_name":"West Ham",
                  "short_code":"WHU",
                  "date_time":"2019-04-27 11:30:00",
                  "date":"27\/04",
                  "time":"11:30",
                  "str_date":"27-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/TOT\/player.png"
            },
            {
               "pld":4,
               "team_id":65,
               "player_id":105,
               "position":"ST",
               "player_first_name":"Peter",
               "player_last_name":"Crouch",
               "user_first_name":"Linda",
               "user_last_name":"Altenwerth",
               "club_id":4,
               "club_name":"Burnley",
               "short_code":"BUR",
               "team_name":"Serenity Bizarre Butchers",
               "total":15,
               "is_processed":0,
               "has_next_fixture":0,
               "status":null,
               "next_fixture":{
                  "type":"H",
                  "club":"Burnley",
                  "short_name":"Man City",
                  "short_code":"MCI",
                  "date_time":"2019-04-28 13:05:00",
                  "date":"28\/04",
                  "time":"13:05",
                  "str_date":"28-Apr"
               },
               "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/BUR\/player.png"
            }
         ]
      },
      "subPlayers":[
         {
            "pld":23,
            "team_id":65,
            "player_id":353,
            "position":"FB",
            "player_first_name":"Ben",
            "player_last_name":"Chilwell",
            "user_first_name":"Linda",
            "user_last_name":"Altenwerth",
            "club_id":11,
            "club_name":"Leicester City",
            "short_code":"LEI",
            "team_name":"Serenity Bizarre Butchers",
            "total":277,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Leicester",
               "short_name":"Arsenal",
               "short_code":"ARS",
               "date_time":"2019-04-29 19:00:00",
               "date":"29\/04",
               "time":"19:00",
               "str_date":"29-Apr"
            },
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/LEI\/player.png"
         },
         {
            "pld":0,
            "team_id":65,
            "player_id":252,
            "position":"GK",
            "player_first_name":"Jo\u00e3o Manuel",
            "player_last_name":"Neves Virginia",
            "user_first_name":"Linda",
            "user_last_name":"Altenwerth",
            "club_id":8,
            "club_name":"Everton",
            "short_code":"EVE",
            "team_name":"Serenity Bizarre Butchers",
            "total":0,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Everton",
               "short_name":"Crystal Palace",
               "short_code":"CRY",
               "date_time":"2019-04-27 14:00:00",
               "date":"27\/04",
               "time":"14:00",
               "str_date":"27-Apr"
            },
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/EVE\/GK.png"
         },
         {
            "pld":0,
            "team_id":65,
            "player_id":596,
            "position":"MF",
            "player_first_name":"Nathan",
            "player_last_name":"Holland",
            "user_first_name":"Linda",
            "user_last_name":"Altenwerth",
            "club_id":19,
            "club_name":"West Ham United",
            "short_code":"WHU",
            "team_name":"Serenity Bizarre Butchers",
            "total":0,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"West Ham",
               "short_name":"Tottenham",
               "short_code":"TOT",
               "date_time":"2019-04-27 11:30:00",
               "date":"27\/04",
               "time":"11:30",
               "str_date":"27-Apr"
            },
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/WHU\/player.png"
         },
         {
            "pld":0,
            "team_id":65,
            "player_id":136,
            "position":"ST",
            "player_first_name":"Rhys",
            "player_last_name":"Healey",
            "user_first_name":"Linda",
            "user_last_name":"Altenwerth",
            "club_id":5,
            "club_name":"Cardiff City",
            "short_code":"CAR",
            "team_name":"Serenity Bizarre Butchers",
            "total":0,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"A",
               "club":"Cardiff",
               "short_name":"Fulham",
               "short_code":"FUL",
               "date_time":"2019-04-27 14:00:00",
               "date":"27\/04",
               "time":"14:00",
               "str_date":"27-Apr"
            },
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CAR\/player.png"
         },
         {
            "pld":0,
            "team_id":65,
            "player_id":206,
            "position":"CB",
            "player_first_name":"Ryan",
            "player_last_name":"Inniss",
            "user_first_name":"Linda",
            "user_last_name":"Altenwerth",
            "club_id":7,
            "club_name":"Crystal Palace",
            "short_code":"CRY",
            "team_name":"Serenity Bizarre Butchers",
            "total":0,
            "is_processed":0,
            "has_next_fixture":0,
            "status":null,
            "next_fixture":{
               "type":"H",
               "club":"Crystal Palace",
               "short_name":"Everton",
               "short_code":"EVE",
               "date_time":"2019-04-27 14:00:00",
               "date":"27\/04",
               "time":"14:00",
               "str_date":"27-Apr"
            },
            "tshirt":"https:\/\/fantasyleague-dev.s3.amazonaws.com\/tshirts\/CRY\/player.png"
         }
      ]
   }
}
```

----
<a name="supersub_check"></a>
## Check Supersub data available or not

This will check if user has supersub data for future fixtues. If return data is greater than 0 then he has saved supersub data for fixtures and then we have to display warning message "If you complete this process, your supersubs will be cancelled". If data is 0 then we don't need to show message.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|GET|`/api/team/{team}/supersub/check`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team`|`integer`|`required (Team id)`|Ex: `65`

> {success} Success Response

Code `200`

Content

```json
{
    "data": 17
}
```

----
<a name="save_supersub_data"></a>
## Save Supersub data

This will save supersub data for future fixtures which will be applied to teamlineup table before fixture starts

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/supersub/save`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team_id`|`integer`|`required (team id)`|Ex: `65`
|`fixture_date`|`date_time`|`required (selected fixture date_time)`|Ex: `2019-04-28 13:05:00`
|`active_players`|`json`|`required (lineup players)`|Ex: check "activePlayers" json in above any api response
|`sub_players`|`json`|`required (Substitute players)`|Ex: check "subPlayers" json in above any api response
|`first_fixture`|`boolean`|`required`|Ex: `true|false`

Note: if 'first_fixture' is true then it updates team player contract (current lineup) immediately else it saves in supersub table and fetch from supersub table

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "status": "success",
        "message": "Done"
    }
}
```

----
<a name="delete_supersub_data"></a>
## Delete Supersub data

This will delete supersub data when user clicks on "Cancel supersubs" button.

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/supersub/delete`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team_id`|`integer`|`required (team id)`|Ex: `65`
|`fixture_date`|`date_time`|`required (selected fixture date_time)`|Ex: `2019-04-28 13:05:00`

> {success} Success Response

Code `200`

Content

```json
{
    "data": {
        "status": "success",
        "message": "Done"
    }
}
```

----
<a name="check_next_fixture_data"></a>
## Check next first fixture data from supersub saved or not

This will check data has been saved first fixture (next one) from fixtures slider from supersub. Actually, we immediately update teamlineup data for first fixture. We are not saving first fixture data in supersub table. So, we can check data is already updated or not by using this api

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/supersub/check/next_fixture_data`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`team_id`|`integer`|`required (team id)`|Ex: `65`
|`fixture_date`|`date_time`|`required (selected fixture date_time)`|Ex: `2019-04-28 13:05:00`

Note: 
A)if return data is greater than 0 then user has updated teamlineup data from supersub for next fixture. So we should hide "Cancel supersubs" button

B)if return data is 0 then user has not updated data for next fixture. 
a) if active players available on bench then we will display Accept/Edit button
b) if no active players available on bench then we will disable Accept button and user can access only edit button

> {success} Success Response

Code `200`

Content

```json
{
    "data": 2
}
```

----
<a name="clubs_for_fixtures"></a>
## Get clubs who have match for fixture date

### Endpoint

|Method|URI|Headers|
|:-|:-|:-|
|POST|`/api/team/supersub/fixtures`|`Bearer Token`|

### Data Params

|Param|Type|Value|Example
|:-|:-|:-|:-
|`clubs`|`json`|`required (active clubs id)`|Ex: `{"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"10":10,"11":11,"13":13,"14":14,"18":18}`
|`date_time`|`date_time`|`required (selected fixture date_time)`|Ex: `2019-04-28 13:05:00`

Note: You can get active clubs by using [Lineup](#lineup) api. You have to take "teamClubs" from lineup api and send in this api.

> {success} Success Response

Code `200`

Content

```json
{
    "data": [
        {
            "home_club_name": "Leicester City",
            "away_club_name": "Arsenal"
        }
    ]
}
```