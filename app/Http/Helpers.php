<?php

use App\Models\Division;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

if (! function_exists('get_date_time_in_carbon')) {
    /**
     * Return the Carbon object.
     */
    function get_date_time_in_carbon($datetime)
    {
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $datetime);

        return $dt->tz(config('fantasy.time.timezone'));
    }
}

if (! function_exists('carbon_format_to_date')) {
    /**
     * Return the formatted date string.
     */
    function carbon_format_to_date($date)
    {
        if ($date instanceof Carbon) {
            return $date->tz(config('fantasy.time.timezone'))->format(config('fantasy.date.format'));
        } elseif ($date) {
            return Carbon::createFromFormat(config('fantasy.db.date.format'), $date)->tz(config('fantasy.time.timezone'))->format(config('fantasy.date.format'));
        }
    }
}

if (! function_exists('carbon_create_from_date')) {
    /**
     * Return the Carbon object.
     */
    function carbon_create_from_date($date)
    {
        return Carbon::createFromFormat(config('fantasy.date.format'), $date);
    }
}

if (! function_exists('carbon_format_to_time')) {
    /**
     * Return the Carbon object.
     */
    function carbon_format_to_time($time, $noSeconds = false, $addDay = false)
    {
        $dt = new Carbon($time);
        $format = config('fantasy.time.format');

        if ($noSeconds) {
            $format = config('fantasy.timewithoutsecond.format');
        }

        if ($addDay) {
            return $dt->tz(config('fantasy.time.timezone'))->addDay($addDay)->format($format);
        }

        return $dt->tz(config('fantasy.time.timezone'))->format($format);
    }
}

if (! function_exists('carbon_format_to_date_for_fixture')) {
    /**
     * Return the Carbon object.
     */
    function carbon_format_to_date_for_fixture($time, $noSeconds = false)
    {
        $dt = new Carbon($time);
        $format = config('fantasy.date_fixture.format');

        return $dt->tz(config('fantasy.date_fixture.timezone'))->format($format);
    }
}

if (! function_exists('carbon_format_to_date_for_fixture_format1')) {
    /**
     * Return the Carbon object.
     */
    function carbon_format_to_date_for_fixture_format1($time, $noSeconds = false)
    {
        $dt = new Carbon($time);
        $format = config('fantasy.date_fixture.format1');

        return $dt->tz(config('fantasy.date_fixture.timezone'))->format($format);
    }
}

if (! function_exists('carbon_format_to_time_for_fixture')) {
    /**
     * Return the Carbon object.
     */
    function carbon_format_to_time_for_fixture($time, $noSeconds = false)
    {
        $dt = new Carbon($time);
        $format = config('fantasy.date_fixture.time_format');

        return $dt->tz(config('fantasy.date_fixture.timezone'))->format($format);
    }
}

if (! function_exists('carbon_format_to_datetime_for_fixture')) {
    /**
     * Return the Carbon object.
     */
    function carbon_format_to_datetime_for_fixture($date)
    {
        $dt = new Carbon($date);
        $format = config('fantasy.date_fixture.datetime_format');

        return $dt->tz(config('fantasy.date_fixture.timezone'))->format($format);
    }
}

if (! function_exists('carbon_format_to_datetime_for_fixture_mail')) {
    /**
     * Return the Carbon object.
     */
    function carbon_format_to_datetime_for_fixture_mail($date)
    {
        $dt = new Carbon($date);
        $format = config('fantasy.date_fixture.mail');

        return $dt->format($format);
    }
}

if (! function_exists('is_json')) {
    /*
     * Get the input data.
     *
     * @param $json The image json.
     *
     * @return Images json.
     *
     */
    function is_json($string)
    {
        json_decode($string);

        return json_last_error() == JSON_ERROR_NONE;
    }
}

if (! function_exists('escape_like')) {
    /*
     * Escape the input that should be supplied
     * to a like query..
     *
     * @param $input
     *
     * @return string
     *
     */
    function escape_like($value, $char = '\\')
    {
        return str_replace(
            [$char, '%', '_'],
            [$char.$char, $char.'%', $char.'_'],
            $value
        );
    }
}
if (! function_exists('string_split_firstname_lastname')) {
    /**
     * Formats the name first name last name.
     *
     * @param  string $name
     * @return string
     */
    function string_split_firstname_lastname($string = null)
    {
        $name = explode(' ', $string);
        if (count($name) == 1) {
            $data['first_name'] = $string;
            $data['last_name'] = '';
        } else {
            $data['last_name'] = array_pop($name);
            $data['first_name'] = implode(' ', $name);
        }

        return $data;
    }
}

if (! function_exists('carbon_set_db_date_time')) {
    /**
     * Convert datetime as per DB .
     *
     * @param  date $dateTime
     * @return date
     */
    function carbon_set_db_date_time($dateTime)
    {
        if ($dateTime instanceof Carbon) {
            return $dateTime->format(config('fantasy.db.datetime.format'));
        } elseif ($dateTime) {
            return Carbon::createFromFormat(config('fantasy.time.format'), $dateTime, config('fantasy.time.timezone'))->tz('UTC')->format(config('fantasy.db.datetime.format'));
        }
    }
}

if (! function_exists('carbon_set_db_date')) {
    /**
     * Convert date as per DB .
     *
     * @param  date $date
     * @return date
     */
    function carbon_set_db_date($date)
    {
        if ($date instanceof Carbon) {
            return $date->format(config('fantasy.db.date.format'));
        } elseif ($date) {
            return Carbon::createFromFormat(config('fantasy.date.format'), $date, config('fantasy.date.timezone'))->tz('UTC')->format(config('fantasy.db.date.format'));
        }
    }
}

if (! function_exists('manage_time_secound')) {
    /**
     * if secounds is not pass then manage .
     *
     * @param  $time
     * @return time
     */
    function manage_time_secound($time)
    {
        $t = explode(':', $time);
        if (! isset($t[2])) { // if secound is not pass in timeformat
            $time = $time.':00';
        }

        return $time;
    }
}

if (! function_exists('player_position_short')) {
    /**
     *  .
     *
     * @param  $position
     * @return position
     */
    function player_position_short($position)
    {
        if ($position) {
            return substr($position, strpos($position, '(') + 1, -1);
        }

        return $position;
    }
}

if (! function_exists('carbon_get_months_between_dates')) {
    /**
     * Get All Months between two dates .
     *
     * @param  date $dateTime
     * @return date
     */
    function carbon_get_months_between_dates($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->modify('first day of this month');
        $end = Carbon::parse($endDate)->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $periods = new DatePeriod($start, $interval, $end);

        $months = [];
        foreach ($periods as $dt) {
            $temp['monthName'] = $dt->monthName;
            $temp['startDate'] = clone $dt->startofDay();
            $temp['endDate'] = clone $dt->endOfMonth();
            $months[] = $temp;
        }

        return $months;
    }
}

if (! function_exists('string_preg_replace')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function string_preg_replace($string)
    {
        return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
    }
}

if (! function_exists('carbon_set_to_text_date')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  date
     * @return date
     */
    function carbon_set_to_text_date($datetime)
    {
        if ($datetime instanceof Carbon) {
            return $datetime->format('jS F, Y');
        } elseif ($datetime) {
            return Carbon::parse($datetime)->format('jS F, Y');
        }
    }
}

if (! function_exists('get_nearest_power_value')) {
    /**
     * get number and return nearest pwer number.
     *
     * @param  int $number , int power (Default power is 2)
     * @return int
     */
    function get_nearest_power_value($number, $power = 2)
    {
        if (is_int($number)) {
            return pow($power, floor(log($number) / log($power)));
        }

        return $number;
    }
}

if (! function_exists('get_log_value')) {
    /**
     * get number and return log with round a number upward to its nearest integer.
     *
     * @param  int $number , int base (Default base is 2)
     * @return int
     */
    function get_log_value($number, $base = 2)
    {
        if (is_int($number)) {
            return (int) ceil(log($number, $base));
        }

        return $number;
    }
}

if (! function_exists('bye_teams_count')) {
    /**
     * get number and return log with round a number upward to its nearest integer.
     *
     * @param  int $number , int base (Default base is 2)
     * @return int
     */
    function bye_teams_count($number)
    {
        if (is_int($number)) {
            $near_power = get_nearest_power_value($number);
            $teams_to_be_eliminate = $number - $near_power;
            $byes_team_count = 0;

            if ($teams_to_be_eliminate > 0) {
                $byes_team_count = $number - ($teams_to_be_eliminate * 2);
            }

            return (int) $byes_team_count;
        }

        return $number;
    }
}

if (! function_exists('get_team_size')) {
    /**
     * get number and return nearest pwer number.
     *
     * @param  int $number , int power (Default power is 2)
     * @return int
     */
    function get_team_size($value)
    {
        if ($value >= 5 && $value <= 7) {
            return 7;
        } elseif ($value >= 8 && $value <= 10) {
            return 10;
        } elseif ($value >= 11 && $value <= 13) {
            return 13;
        } elseif ($value >= 14 && $value <= 16) {
            return 16;
        }

        return $value;
    }
}

if (! function_exists('format_formations')) {
    /**
     * get formation in r=format e.g., 4-4-2.
     *
     * @param  array $availableFormations
     * @return string
     */
    function format_formations($availableFormations)
    {
        $formations = [];
        foreach ($availableFormations as $formation) {
            $forms = [];
            for ($cnt = 0; $cnt < strlen($formation); $cnt++) {
                $forms[] = substr($formation, $cnt, 1);
            }
            $formations[] = implode('-', $forms);
        }
        $formations = implode(', ', $formations);

        return $formations;
    }
}

if (! function_exists('get_month_between_dates')) {
    /**
     * get Month numbers between  given start/end dates.
     *
     * @param startDate
     * @param  endDate
     * @return string
     */
    function get_month_between_dates($startDate, $endDate)
    {
        $start = (new Carbon($startDate))->modify('first day of this month');
        $end = (new Carbon($endDate))->modify('first day of next month');
        $interval = CarbonInterval::createFromDateString('1 month');
        $period = new CarbonPeriod($start, $interval, $end);

        $months = [];
        foreach ($period as $dt) {
            $months[] = $dt->format('M');
        }

        return $months;
    }
}

if (! function_exists('carbon_get_time_from_date')) {
    /**
     * Get only time from datetime .
     *
     * @param  date
     * @return date
     */
    function carbon_get_time_from_date($datetime)
    {
        return Carbon::parse($datetime)->format(config('fantasy.messagetime.format'));
    }
}

if (! function_exists('is_now_between_dates')) {
    /**
     * Get only time from datetime .
     *
     * @param  start
     * @return true if now date is between pass star end date
     */
    function is_now_between_dates($start, $end)
    {
        if (Carbon::parse($start)->format(config('fantasy.db.date.format')) <= Carbon::now()->format(config('fantasy.db.date.format')) && Carbon::now()->format(config('fantasy.db.date.format')) <= Carbon::parse($end)->format(config('fantasy.db.date.format'))) {
            return true;
        }

        return false;
    }
}

if (! function_exists('number_formatter_en_us')) {
    /**
     * Get only number.
     *
     * @param  number
     * @return 1st, 2nd format the number
     */
    function number_formatter_en_us($number)
    {
        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);

        return $numberFormatter->format($number);
    }
}

if (! function_exists('has_join_league_request')) {
    /**
     * Check if previous request was join a league request.
     *
     * @return true if intended URL is Join an League
     */
    function has_join_league_request($url)
    {
        if (strpos($url, 'join/a/league')) {
            return true;
        }

        return false;
    }
}

if (! function_exists('carbon_format_view_date')) {
    /**
     * Return the formatted date string.
     */
    function carbon_format_view_date($date)
    {
        return Carbon::parse($date)->format(config('fantasy.view.day_month_year_time'));
    }
}

if (! function_exists('player_position_except_code')) {
    /**
     *  .
     *
     * @param  $position
     * @return position
     */
    function player_position_except_code($position)
    {
        if ($position) {
            return substr($position, 0, strpos($position, ' ('));
        }

        return $position;
    }
}
if (! function_exists('division_name_for_invite_code')) {
    /**
     * Get division name for the invite code.
     *
     * @return true if intended URL is Join an League
     */
    function division_name_for_invite($url)
    {
        $inviteUrl = explode('/', $url);
        $code = end($inviteUrl);
        $division = Division::whereHas('inviteCode', function ($query) use ($code) {
            $query->where('code', $code);
        })
        ->first();

        return $division;
    }
}

if (! function_exists('removeAccents')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function removeAccents($string)
    {
        $nativeAccents = ['À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'ð', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή'];

        $englishAccents = ['A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η'];

        return str_replace($nativeAccents, $englishAccents, $string);
    }
}

if (! function_exists('player_position_full')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function player_position_full($string)
    {
        $positions = \App\Enums\PlayerContractPosition\ShortToFullPositionEnum::toArray();

        return $positions[$string];
    }
}

if (! function_exists('player_tshirt')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function player_tshirt($shortCode, $position)
    {
        $s3Url = config('fantasy.aws_url').'/tshirts/';

        if ($position == 'GK') {
            $url = $s3Url.$shortCode.'/GK.png';
        } else {
            $url = $s3Url.$shortCode.'/player.png';
        }

        return $url;
    }
}

if (! function_exists('player_status')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function player_status($status)
    {
        if(!$status || $status == null || $status == '') {

            return '';
        }

        $s3Url = config('fantasy.aws_url').'/status/';

        return strtolower(implode('', explode(' ', $status))).'.svg';
    }
}


if (! function_exists('paginate_collection')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function paginate_collection($collection, $perPage, $url = '')
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentPageItems = $collection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        if (! $url) {
            $url = url()->full();
        }

        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);

        $paginatedItems->setPath($url);

        return $paginatedItems;
    }
}

if (! function_exists('get_substring_from_string')) {
    /**
     * Get string and remove spaces from string .
     *
     * @param  string $string
     * @return string
     */
    function get_substring_from_string($string, $start, $end)
    {
        $string = ' '.$string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }
}
if (! function_exists('number_clean')) {
    /**
     * Get number and set friction of number .
     *
     * @param  number $number
     * @return number
     */
    function number_clean($num)
    {
        $num = number_format($num, 2, '.', '');

        $split = explode('.', $num);
        if ($split[1] == 0) {
            //$num = number_format($num, 2, '.', ',');
            $clean = rtrim($num, '0');
            $clean = rtrim($clean, '.');
            if ($num == 0.00) {
                return $clean;
            }
        }

        return number_format($num, 2, '.', ',');
    }
}

if (! function_exists('get_player_name')) {
    /**
     * Formats the name first name last name based on nameType.
     *
     * @param  string $nameType, $firstName, $lastName
     * $nameType can be fullName, lastName, firstNameFirstCharAndFullLastName
     * @return string
     */
    function get_player_name($nameType, $firstName = null, $lastName = null)
    {
        $playerName = '';
        if ($nameType == 'fullName') {
            if (! empty($firstName)) {
                $playerName = ucfirst($firstName);
            }

            if (! empty($lastName)) {
                $playerName = $playerName ? $playerName.' '.ucfirst($lastName) : ucfirst($lastName);
            }
        } elseif ($nameType == 'lastName') {
            if (! empty($lastName)) {
                $playerName = ucfirst($lastName);
            }
        } elseif ($nameType == 'firstNameFirstCharAndFullLastName') {
            if (! empty($firstName)) {
                $playerName = ucfirst($firstName[0]);
            }

            if (! empty($lastName)) {
                $playerName = $playerName ? $playerName.'. '.ucfirst($lastName) : ucfirst($lastName);
            }
        }

        return $playerName;
    }
}

if (! function_exists('check_number_is_divisible')) {
    /**
     * Get divisiblen number and dividing number, check is divisible or not.
     *
     * @param  number $divisibleNumber, $dividingNumber
     * @return bool
     */
    function check_number_is_divisible($divisibleNumber, $dividingNumber)
    {
        if ($divisibleNumber == 0 || $dividingNumber == 0) {
            return true;
        }

        $mod = round(fmod(round($dividingNumber * 100000), round($divisibleNumber * 100000))) / 100000;

        return ($mod == 0.0 || $mod == 0) ? true : false;
        /*
        if (is_float($dividingNumber)) {
            $reminder = (string) ($divisibleNumber / $dividingNumber) + 0;
            if (is_float($reminder)) {
                return false;
            }
            return true;
        }
        return ($divisibleNumber % $dividingNumber == 0) ? true : false;
        */
    }
}

if (! function_exists('carbon_get_date_from_date_time')) {
    /**
     * Get only time from datetime .
     *
     * @param  date
     * @return date
     */
    function carbon_get_date_from_date_time($datetime)
    {
        return Carbon::parse($datetime)->format(config('fantasy.db.date.format'));
    }
}

if (! function_exists('get_decimal_part_of_a_number')) {
    /**
     * Get only count from number.
     *
     * @param  number
     * @return number
     */
    function get_decimal_part_of_a_number($number)
    {
        $len = strlen(substr(strrchr($number, '.'), 1));

        return ($len == 1) ? ($len + 1) : $len;
    }
}

if (! function_exists('set_if_float_number_format')) {
    /**
     * Get formated number if float.
     *
     * @param  number
     * @return int/float
     */
    function set_if_float_number_format($number)
    {
        $count = get_decimal_part_of_a_number($number);

        if ($count > 0) {
            $number = number_format($number, 2, '.', '');
            $number = $number + 0;

            return $number;
        }

        return intval($number);
    }
}
if (! function_exists('get_group_stage_and_number')) {
    /**
     * Get group stage name and number.
     *
     * @param  object
     * @return array
     */
    function get_group_stage_and_number($groupStage, $returnVal = 'stage')
    {
        $stage = 'Week';
        $number = substr($groupStage->name, -1);

        if (substr($groupStage->name, 0, 1) != 'G') {
            $totalFixture = $groupStage->championEuropaFixtures
                            ->count();
            if ($totalFixture == 8) {
                $stage = 'QF';
                $number = '';
            } elseif ($totalFixture == 4) {
                $stage = 'SF';
                $number = '';
            } elseif ($totalFixture == 2) {
                $stage = 'F';
                $number = '';
            } else {
                $stage = 'Round';
            }
        }
        if ($returnVal === 'stage') {
            return $stage;
        }

        return $number;
    }
}

if (! function_exists('get_team_position_from_rank_points')) {
    /**
     * Get team position from rank.
     *
     * @param  array
     * @return array
     */
    function get_team_position_from_rank_points($allTeamRankPoints = [])
    {
        $rank = 1;
        $tie_rank = 0;
        $prev = -1;
        $teamPositions = [];
        foreach ($allTeamRankPoints as $key => $points) {
            if ($points != $prev) {
                $count = 0;
                $prev = $points;
                $teamPositions[$key] = $rank;
            } else {
                $prev = $points;
                if ($count++ == 0) {
                    $tie_rank = $rank - 1;
                }
                $teamPositions[$key] = $tie_rank;
            }
            $rank++;
        }

        return collect($teamPositions);
    }
}

if (! function_exists('carbon_format_to_view_date')) {
    /**
     * Return the formatted date string.
     */
    function carbon_format_to_view_date($date)
    {
        if ($date instanceof Carbon) {
            return $date->tz(config('fantasy.time.timezone'))->format(config('fantasy.view_date.date.format'));
        } elseif ($date) {
            return Carbon::createFromFormat(config('fantasy.db.date.format'), $date)->tz(config('fantasy.time.timezone'))->format(config('fantasy.view_date.date.format'));
        }
    }
}

if (! function_exists('add_slash_in_url_end')) {
    /**
     * Return the url with slash.
     */
    function add_slash_in_url_end($url)
    {
        return rtrim($url,"/").'/';
    }
}
