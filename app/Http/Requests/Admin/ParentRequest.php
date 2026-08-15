<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return [

                /*'username'   => 'required|max:30|unique:users,username',
                'password'   => 'required|min:8',*/
                'name'       => 'required|max:50',
                'gender_id'  => 'required|exists:genders,id',
                'address'    => 'nullable|max:100',
                'telephone'  => 'nullable|max:20|unique:parents,telephone',
                'email'      => 'required|email|unique:parents,email',
                /*'status'     => 'required|boolean',*/

            ];
        }
        return [

            'name'       => 'required|max:50',
            'gender_id'  => 'required|exists:genders,id',
            'email'      => 'nullable|email',
            'telephone'  => 'nullable|max:20',
            'address'    => 'nullable|max:100',

        ];
    }
}
