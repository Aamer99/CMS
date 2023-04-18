<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=> ["required",'min:3'],
            'email'=> ['required','email','lowercase','unique:customers'],
            'password' => ['required','min:6'],
            'phoneNumber' => ['required']

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'sorry, the name is required.',
            'email.required' => 'sorry,the email is required.',
            'password.required' => 'sorry,the password is required',
            'phoneNumber.required'=> "sorry, the phone number is required",
            'email.email'=> 'sorry, you need to enter valid email address.',
            'email.unique' => "sorry, the email exists, try something else.",
            'password.min'=> 'sorry, the password should be at least 6 characters'
        ];
    }
}
