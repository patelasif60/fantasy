<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionAuction extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pre_season_auction_budget' => 'nullable|numeric|min:0|max:1000',
            'pre_season_auction_bid_increment' => 'nullable|numeric|min:0|max:10',
            'auction_date' => 'nullable|date_format:d/m/Y H:i:s',
        ];
    }
}
