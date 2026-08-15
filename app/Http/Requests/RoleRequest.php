<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('role');

        return [
            'id' => [
                'required',
                'max:3',
                Rule::unique('roles', 'id')->ignore($id),
            ],

            'nama' => [
                'required',
                'max:50',
            ],

            'keterangan' => [
                'nullable',
                'max:255',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}
