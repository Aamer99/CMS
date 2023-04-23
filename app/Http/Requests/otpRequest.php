<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class otpRequest extends FormRequest
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
            'otp'=> ["required",'digits:6']
        ];
    }

    public function messages(){
        return [
            'otp.required' => "the OTP is required",
            'otp.digits'=> "the OTP code is should be 6 numbers",
            // 'otp.min'=> "the OTP code is should be 6 numbers",
            // 'otp.integer'=> "the OTP should be numbers"
        ];
    }
}
