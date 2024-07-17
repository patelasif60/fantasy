<?php

namespace App\Http\Requests\InviteManager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SendInvitationRequest extends FormRequest
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
        return [
            'phone.*' => 'required|phone',
            'email.*' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'phone.*.phone' => 'Please enter valid phone number',
            'email.*.email' => 'Please enter valid email address',
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();

        unset($data['_token']);
        $i = 0;
        foreach ($data as $key => $value) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $data['email'][] = $value;
            } else {
                $data['phone'][] = $value;
            }
            unset($data['invite_email_'.$i]);
            $i++;
        }

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
