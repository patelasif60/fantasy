<?php

namespace App\Rules\Player\Contract;

use App\Models\PlayerContract;
use Carbon\Carbon;
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
        $appContract = PlayerContract::where('player_id', $this->player_id)
                    ->whereDate('start_date', '<=', carbon_set_db_date($value))
                    ->whereDate('end_date', '>=', carbon_set_db_date($value));

        if (! empty($this->id)) {
            $appContract = $appContract->where('id', '!=', $this->id);
        }

        if ($appContract->count() > 0) {
            return false;
        }

        $appContractWithEndDate = PlayerContract::where('player_id', $this->player_id)->where('end_date', null);

        if (! empty($this->id)) {
            $appContractWithEndDate = $appContractWithEndDate->where('id', '!=', $this->id);
        }

        $appContractWithEndDate = $appContractWithEndDate->first();

        if (! $appContractWithEndDate) {
            return true;
        }

        if ($value && request()->get('end_date') == null) {
            return false;
        }

        $dbStart = Carbon::createFromFormat('Y-m-d', $appContractWithEndDate->start_date)->startOfDay();
        $newStart = Carbon::createFromFormat('d/m/Y', $value)->startOfDay();
        $newEnd = Carbon::createFromFormat('d/m/Y', request()->get('end_date'))->startOfDay();

        if (($dbStart >= $newStart) && ($dbStart <= $newEnd)) {
            return false;
        }

        if ($newStart->diffInDays($dbStart) < 1) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('player.validation.ct_date_overlap');
    }
}
