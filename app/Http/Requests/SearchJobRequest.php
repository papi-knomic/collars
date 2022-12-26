<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( auth()->user()->is_worker ) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' =>  ['nullable', 'string', 'max:255'],
            'description' =>  ['nullable', 'string', 'max:255'],
            'job_id' =>  ['nullable', 'integer', 'exists:job_types,id' ],
            'status' =>  ['nullable', 'string'],
            'min' => [ 'regex:/^\d+(\.\d{1,2})?$/', 'required_with:max'],
            'max' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
