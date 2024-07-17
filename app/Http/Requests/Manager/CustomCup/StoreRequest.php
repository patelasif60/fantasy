<?php

namespace App\Http\Requests\Manager\CustomCup;

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
        $teams = count($this->get('teams'));
        $rounds = get_log_value($teams);
        $byeTeams = bye_teams_count($teams);

        $rules = [
            'name' => 'required|min:3',
            'teams' => 'required|array|min:2',
            'rounds' => "required|array|min:$rounds|max:$rounds",
        ];

        if ($byeTeams && ! $this->has('is_bye_random')) {
            $rules['bye_teams'] = "required|min:$byeTeams|max:$byeTeams";
        }

        foreach ($this->get('rounds') as $round => $gameweeks) {
            $rules['rounds.'.$round] = 'required|array|min:1';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'teams.min' => 'Please select teams',
            'teams.required' => 'Please select at least 3 teams',
            'teams.min' => 'Your cup has required a minimum of :min teams',
            'bye_teams.min' => 'Your cup has required a minimum of :min bye teams',
            'bye_teams.max' => 'Your cup has maximum of :max bye teams',
            'rounds.min' => 'Your cup has required a minimum of :min rounds',
            'rounds.max' => 'Your cup has a maximum of :max rounds',
        ];
    }
}
