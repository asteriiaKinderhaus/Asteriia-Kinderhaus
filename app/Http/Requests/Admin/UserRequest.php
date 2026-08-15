<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'username' => [
                'required',
                'max:50',
                Rule::unique('users')->ignore($id)
            ],

            'password' => [
                $id ? 'nullable' : 'required',
                'min:6'
            ],

            'role_id' => 'required|exists:roles,id',

            'status' => 'required|boolean',
        ];
    }
}
