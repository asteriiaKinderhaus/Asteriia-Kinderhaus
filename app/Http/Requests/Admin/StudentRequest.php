<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            //'nis' => 'required|max:20|unique:students,nis',

            'name' => 'required|max:50',

            'nickname' => 'nullable|max:30',

            'birth_place' => 'nullable|max:50',

            'birth_date' => 'nullable|date',

            'gender_id' => 'required|exists:genders,id',

            'parent_id' => 'required|exists:parents,id',

            'class_id' => 'required|exists:school_classes,id',

            'status' => 'required|boolean',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];
    }
}
