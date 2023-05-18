<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'name'=> ["required_if:name,==,null",'min:3'],
            'email'=> ['required_if:email,==,null','email','lowercase','unique:users'],
            'password' => ['required_if:password,==,null','min:6','confirmed'],
            'phoneNumber' => ['required_if:phoneNumber,==,null'],
            'current_password'=>['required_if:password,==,null','min:6'],
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
