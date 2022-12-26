<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if( auth()->user()->is_user ){
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
            'title' =>  ['required', 'string', 'max:255'],
            'description' =>  ['required', 'string', 'max:255'],
            'job_id' =>  ['required', 'integer', 'exists:job_types,id' ],
            'budget' =>  ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'images' => [ 'array', 'max:4'],
            'images.*' => ['url'],
        ];
    }
}
