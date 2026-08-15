<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FacilitatorRequest extends FormRequest
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
                'birth_date' => 'nullable|date',
                'gender_id'  => 'required|exists:genders,id',
                'email'      => 'required|email|unique:facilitators,email',
                'telephone'  => 'nullable|max:20|unique:facilitators,telephone',
                'address'    => 'nullable|max:100',
                //'status'     => 'required|boolean',

            ];
        }
        return [

            'name'       => 'required|max:50',
            'gender_id'  => 'required|exists:genders,id',
            'birth_date' => 'nullable|date',
            'email'      => 'nullable|email',
            'telephone'  => 'nullable|max:20|unique:facilitators,telephone',
            'address'    => 'nullable|max:100',

        ];
    }
}
