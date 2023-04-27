<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequests extends FormRequest
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
            "description"=> ["required"],
            "requestFile"=> ['mimes:png,jpeg,pdf','required','max:1000']
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'sorry,the description is required.',
            'requestFile.required' => 'sorry, the file is required.',
            'requestFile.mimes'=> "sorry, the file must be png, jpeg, pdf.",
            'requestFile.max'=> 'sorry, the file size must be less than 10000.',
            
        ];
    }

}
