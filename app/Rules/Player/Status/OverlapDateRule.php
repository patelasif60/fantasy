<?php

namespace App\Rules\Player\Status;

use App\Models\PlayerStatus;
use Illuminate\Contracts\Validation\Rule;

class OverlapDateRule implements Rule
{
    protected $id;
    protected $player_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($player_id, $id = null)
    {
        $this->id = $id;
        $this->player_id = $player_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $appStatus = PlayerStatus::where('player_id', $this->player_id)
            ->where('start_date', '<=', carbon_set_db_date($value))
            ->where('end_date', '>=', carbon_set_db_date($value));

        if (! empty($this->id)) {
            $appStatus = $appStatus->where('id', '!=', $this->id);
        }

        return ($appStatus->count() > 0) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('player.validation.st_date_overlap');
    }
}
