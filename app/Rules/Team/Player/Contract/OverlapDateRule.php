<?php

namespace App\Rules\Team\Player\Contract;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class OverlapDateRule implements Rule
{
    protected $request;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $values)
    {
        $overlaps = 0;

        for ($pos = 0; $pos < count($values); $pos++) {
            if ($pos == 0) {
                $start_date = $this->toValidFormat(max($this->request['start_date']));
                $end_date = $this->toValidFormat(max($this->request['end_date']));
            } else {
                $start_date = $this->toValidFormat(max($this->request['start_date_new']));
                $end_date = $this->toValidFormat(max($this->request['end_date_new']));
            }
            if ($values[$pos] != null) {
                $current_date = $this->toValidFormat($values[$pos]);

                if ($current_date->greaterThanOrEqualTo($start_date) && $current_date->lessThanOrEqualTo($end_date)) {
                    $overlaps++;
                }
            }
        }

        return ($overlaps > 0) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Contract Dates Overlapping. Please select valid start & end dates.';
    }

    public function toValidFormat($date)
    {
        if ($date == null) {
            return;
        }
        $date = carbon_set_db_date_time($date);

        return Carbon::parse($date);
    }
}
