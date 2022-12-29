<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if( auth()->user()->is_worker ){
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
            'message' => ['required'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'job_id' => ['required', 'integer', 'exists:jobs,id'],
        ];
    }
}
