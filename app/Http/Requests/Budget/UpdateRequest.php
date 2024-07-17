<?php

namespace App\Http\Requests\Budget;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $monthly_free_agent_transfer_limit = $this->division->getOptionValue('monthly_free_agent_transfer_limit');
        $season_free_agent_transfer_limit = $this->division->getOptionValue('season_free_agent_transfer_limit');

        $rules = [
            'budget_correction' => 'required|array',
            'season_quota_used' => 'required|array',
            'monthly_quota_used' => 'required|array',
        ];

        foreach ($this->request->get('budget_correction') as $key => $val) {

            $rules['budget_correction.'.$key] = 'required|numeric|min:0|max:3000';
        }

        foreach ($this->request->get('season_quota_used') as $key => $val) {

            $rules['season_quota_used.'.$key] = 'required|numeric|min:0|max:'.$season_free_agent_transfer_limit.'';
        }

        foreach ($this->request->get('monthly_quota_used') as $key => $val) {

            $rules['monthly_quota_used.'.$key] = 'required|numeric|min:0|max:'.$monthly_free_agent_transfer_limit.'';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'budget_correction.required' => 'This field is required.',
            'budget_correction.array' => 'Invalid data format.',
            'season_quota_used.required' => 'This field is required.',
            'season_quota_used.array' => 'Invalid data format.',
            'monthly_quota_used.required' => 'This field is required.',
            'monthly_quota_used.array' => 'Invalid data format.',
        ];

        foreach ($this->request->get('budget_correction') as $key => $val) {

            $messages['budget_correction.'.$key.'.required'] = 'This field is required.';
            $messages['budget_correction.'.$key.'.min'] = 'Please enter a value greater than or equal to :min.';
            $messages['budget_correction.'.$key.'.max'] = 'Please enter a value less than or equal to :max.';
        }

        foreach ($this->request->get('season_quota_used') as $key => $val) {

            $messages['season_quota_used.'.$key.'.required'] = 'This field is required.';
            $messages['season_quota_used.'.$key.'.min'] = 'Please enter a value greater than or equal to :min.';
            $messages['season_quota_used.'.$key.'.max'] = 'Please enter a value less than or equal to :max.';
        }

        foreach ($this->request->get('monthly_quota_used') as $key => $val) {

            $messages['monthly_quota_used.'.$key.'.required'] = 'This field is required.';
            $messages['monthly_quota_used.'.$key.'.min'] = 'Please enter a value greater than or equal to :min.';
            $messages['monthly_quota_used.'.$key.'.max'] = 'Please enter a value less than or equal to :max.';
        }

        return $messages;
    }
}
