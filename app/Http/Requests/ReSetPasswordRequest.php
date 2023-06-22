<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReSetPasswordRequest extends FormRequest
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
            
                'current_password' => ['required',"min:6"],
                'password' => ['required', 'min:6', 'confirmed'],
                'token' => ['required']
          
        ];
    }

    public function messages(){
        return [
            'current_password.required' => "the current password is required",
            'current_password.min'=> "the current password is should be 6 characters",
            'password.min'=> "the password is should be at least 6 characters",
            'password.required'=> "the password is required",
             'token.required'=> "the token is required",
        ];
    }
}
