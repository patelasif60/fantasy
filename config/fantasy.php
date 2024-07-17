<?php

/**
 * Basic site configuration variables.
 */
return [

    'datepicker'=>[
        'format' => 'dd/mm/yyyy',
    ],
    'datetimepicker'=>[
        'format' => 'DD/MM/YYYY HH:mm:ss',
    ],
    'datetimedatepicker'=>[
        'format' => 'DD/MM/YYYY',

    ],
    'datetimetimepicker' => [
        'format' => 'HH:mm',
    ],
    'date' => [
        'format' => 'd/m/Y',
        'timezone' => 'Europe/London',
    ],

    'date_fixture' => [
        'format' => 'd/m',
        'format1' => 'd-M',
        'time_format' => 'H:i',
        'datetime_format' => 'Y-m-d H:i:s',
        'timezone' => 'Europe/London',
        'mail' => 'D d-M H:i',
    ],

    'time' => [
        'format' => 'd/m/Y H:i:s',
        'timezone' => 'Europe/London',
    ],
    'messagetime' => [
        'format' => 'H:i a',
        'timezone' => 'Europe/London',
    ],
    'timewithoutsecond' => [
        'format' => 'd/m/Y H:i',
        'timezone' => 'Europe/London',
    ],
    'view' =>[
        'day_month' => 'jS F',
        'day_month_year' => 'jS F Y',
        'day_month_year_time' => 'jS F Y H:i',
        'hour_minute_day_month_year' => 'jS F Y H:i',
        'hour_minute' => 'H:i',
    ],
    'db'=>[
        'date'=> [
            'format'=>'Y-m-d',
        ],
        'datetime'=>[
            'format'=>'Y-m-d H:i:s',
        ],
    ],
    'view_date'=>[
        'date'=> [
            'format'=>'d-m-y',
        ],
    ],
    'currency' => [
        'default' => [
            'format'        => 'GBP',
            'denomination'  => 100,
        ],
    ],

    'rollover_user' => 'rstenson@aecordigital.com',

    'crest_50_na' => getenv('IMAGE_50_NA'),

    'gracenote_outlet_auth_key' => getenv('GRACENOTE_OUTLETAUTHKEY', ''),

    'gracenote_api_url' => getenv('GRACENOTE_API_URL', ''),

    'aws_url' => getenv('AWS_URL', ''),

    'default_admin_email' => getenv('DEFAULT_ADMIN_EMAIL', ''),

    'wordpress_url' => getenv('WORDPRESS_URL', ''),

    'contact_us_email' => getenv('CONTACT_US_EMAIL', ''),

    'pagination' => getenv('PAGINATION', 25),

    'crest_show_live' => getenv('IS_CREST_SHOW_LIVE', false),

    'pitch_url' => add_slash_in_url_end(config('app.url')).'assets/frontend/img/pitch/pitch-1.png',

    'social' => [
        'instagram_url' => getenv('INSTAGRAM_URL'),
        'twitter_url' => getenv('TWITTER_URL'),
        'facebook_url' => getenv('FACEBOOK_URL'),
    ],

    'sealbid_feature_live' => getenv('SEALBID_FEATURE_LIVE', ''),
    'transfer_feature_live' => getenv('TRANSFER_FEATURE_LIVE', ''),
    'supersub_feature_live' => getenv('SUPERSUB_FEATURE_LIVE', ''),
    'swap_feature_live' => getenv('SWAP_FEATURE_LIVE', ''),
    'only_one_time_for_champion_euroapa' => getenv('ONLY_ONE_TIME_FOR_CHAMPION_EUROAPA', false),
    'is_customcup_demo' => getenv('IS_CUSTOMCUP_DEMO', ''),
    'point_recalculation_days' =>  7,
    'is_production' =>  getenv('IS_PRODUCTION', ''),
    'future_fixtures_limit_supersub' =>  env('FUTURE_FIXTURES_LIMIT_SUPERSUB', 14),
    'report' => [
        'emails' => ['andrew@fantasyleague.com', 'matts@fantasyleague.com', 'ndeopura@aecordigital.com', 'mlakdawala@aecordigital.com'],
    ],
    'default_point_scoring' => [
        'GK'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 2,
            'goal_conceded' => -1,
            'appearance' => 1,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
        'CB'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 2,
            'goal_conceded' => -1,
            'appearance' => 1,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
        'FB'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 2,
            'goal_conceded' => -1,
            'appearance' => 1,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
        'DF'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 2,
            'goal_conceded' => -1,
            'appearance' => 1,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
        'DMF'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 0,
            'goal_conceded' => 0,
            'appearance' => 0,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
        'MF'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 0,
            'goal_conceded' => 0,
            'appearance' => 0,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
        'ST'=>  [
            'goal' => 3,
            'assist' => 2,
            'clean_sheet' => 0,
            'goal_conceded' => 0,
            'appearance' => 0,
            'club_win' => 0,
            'yellow_card' => 0,
            'red_card' => 0,
            'own_goal' => 0,
            'penalty_missed' => 0,
            'penalty_save' => 0,
            'goalkeeper_save_x5' => 0,
        ],
    ],
];
