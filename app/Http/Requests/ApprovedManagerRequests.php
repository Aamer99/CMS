<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovedManagerRequests extends FormRequest
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
            'request_type'=> ['required', 'integer'],
             'user_id'=> ['string',"required_if:request_type,1"],
             'request_id'=> ['integer',"required_if:request_type,2"],
        ];
    }
    public function messages()
    {
        return [
            'request_type.required' => 'sorry, the request type is required.',
            'request_type.integer'=> "sorry, the id should by a integer number",
            'user_id.required_if' => 'sorry,the user id  is required.',
            'user_id.string'=> 'sorry, the id should by string.',
            'request_id.required_if' => 'sorry,the request id is required',
            'request_id.integer' => 'sorry, the id should by a integer number',
        ];
    }
}
