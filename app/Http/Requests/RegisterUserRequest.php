<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => ['required','string', Rule::in(getUserRoles())],
            'location' => 'required|string',
            'job_type' => ["required_if:role,==,worker",'exists:job_types,id'],
            'phone' => ["required", 'unique:users,phone', 'regex:/^0(70|8(0|1)|9(0|1))\d{8}$/']
//            'bvn' => ['string', 'unique:users,bvn', "required_if:role,==,worker"]
        ];
    }
}
