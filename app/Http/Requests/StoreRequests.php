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
            "title" => ["required","min:3"],
            "description"=> ["required","min:3"],
            "requestFile"=> ['mimes:png,jpeg,pdf','required','max:1000'],
            "department_id"=> ["required"],
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'sorry,the description is required.',
            'requestFile.required' => 'sorry, the file is required.',
            'requestFile.mimes'=> "sorry, the file must be png, jpeg, pdf.",
            'requestFile.max'=> 'sorry, the file size must be less than 10000.',
            'department_id.required' => 'sorry, the department is required.',
            'title.required' => ' sorry, the title is required.',
            'title.min' => 'Sorry, the title should be at least 3 characters',
            'description.min' => 'Sorry, the description should be at least 3 characters'
            
        ];
    }

}
