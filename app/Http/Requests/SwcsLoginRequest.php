<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SwcsLoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'nullable',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'SSO_MESSAGE' => 'required|in:SUCCESS',
            'SSO_STATUS_CODE' => 'required|in:200',
            'SSO_TOKEN' => 'required',
            'SSO_HREF' => 'required|url',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        return new HttpResponseException(redirect()->route('login')->withErrors($validator->errors()));
    }
}
