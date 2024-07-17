<?php

namespace App\Http\Requests\Division\Auction;

use App\Enums\AuctionTypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $date = now()->format('d-m-Y');

        $rules = [
            'auction_types' => 'sometimes|required|in:'.AuctionTypesEnum::OFFLINE_AUCTION.','.AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION,
            'auction_date' => 'sometimes|required|date_format:d/m/Y',
            'auction_time' => 'sometimes|required|date_format:H:i:s',
            'pre_season_auction_budget' => 'sometimes|required|numeric|min:0|max:1000',
            'pre_season_auction_bid_increment' => 'sometimes|required|numeric|min:0|max:10',
        ];

        $checkValidation = false;
        if ($this->request->has('auction_types')) {
            if ($this->request->get('auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
                $checkValidation = true;
            }
        } else {
            if ($this->division->auction_types == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
                $checkValidation = true;
            }
        }

        if ($checkValidation) {
            foreach ($this->request->get('round_end_date') as $key => $val) {
                $rules['round_end_date.'.$key.'.'.key($val)] = 'required|date_format:d/m/Y';
            }

            foreach ($this->request->get('round_end_time') as $key => $val) {
                $rules['round_end_time.'.$key.'.'.key($val)] = 'required|date_format:H:i:s';
            }

            $rules['tie_preference'] = 'sometimes|required';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'auction_types.required' => 'Auction type field is required.',
            'auction_date.required' => 'Auction date field is required.',
            'auction_date.after_or_equal' => "The auction date cannot be set before today's date",
            'auction_time.required' => 'Auction time field is required.',
            'tie_preference.required' => 'Tie bid preference field is required.',
            'pre_season_auction_budget.required' => 'Auction budget field is required.',
            'pre_season_auction_budget.min' => 'Please enter a value greater than or equal to :min.',
            'pre_season_auction_budget.max' => 'Please enter a value less than or equal to :max.',
            'pre_season_auction_bid_increment.required' => 'Bid increment field is required.',
            'pre_season_auction_bid_increment.min' => 'Please enter a value greater than or equal to :min.',
            'pre_season_auction_bid_increment.max' => 'Please enter a value less than or equal to :max.',
        ];

        if ($this->division->auction_types == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION || $this->request->get('auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            foreach ($this->request->get('round_end_date') as $key => $val) {
                $messages['round_end_date.'.$key.'.'.key($val).'.required'] = 'The round end date field is required.';
                $messages['round_end_date.'.$key.'.'.key($val).'.date_format'] = 'The round end date is invalid.';
                //$messages['round_end_date.'.$key.'.'.key($val).'.after_or_equal'] = "The round end date cannot be set before today's date";
            }

            foreach ($this->request->get('round_end_time') as $key => $val) {
                $messages['round_end_time.'.$key.'.'.key($val).'.required'] = 'The round end time field is required.';
                $messages['round_end_time.'.$key.'.'.key($val).'.date_format'] = 'The round end time is invalid.';
            }
        }

        return $messages;
    }
}
