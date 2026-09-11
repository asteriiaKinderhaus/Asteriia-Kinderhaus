<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentRegistrationRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | DATA PESERTA DIDIK
            |--------------------------------------------------------------------------
            */

            'student_name' => [
                'required',
                'string',
                'max:50',
            ],

            'student_nickname' => [
                'nullable',
                'string',
                'max:30',
            ],

            'student_birth_place' => [
                'nullable',
                'string',
                'max:50',
            ],

            'student_birth_date' => [
                'nullable',
                'date',
            ],

            'student_gender_id' => [
                'required',
                'exists:genders,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | DATA ORANG TUA
            |--------------------------------------------------------------------------
            */

            /*
             * parent_id kosong
             * = orang tua baru
             *
             * parent_id terisi
             * = menggunakan orang tua yang sudah ada
             */

            'parent_id' => [
                'nullable',
                'exists:parents,id',
            ],

            'parent_name' => [
                'required',
                'string',
                'max:50',
            ],

            'parent_gender_id' => [
                'required_without:parent_id',
                'nullable',
                'exists:genders,id',
            ],

            'parent_address' => [
                'required_without:parent_id',
                'nullable',
                'string',
                'max:100',
            ],

            'parent_telephone' => [
                'required_without:parent_id',
                'nullable',
                'string',
                'max:20',
            ],

            'parent_email' => [
                'nullable',
                'email',
                'max:50',
            ],
        ];
    }

    /**
     * Pesan validasi.
     */
    public function messages(): array
    {
        return [

            'student_name.required' =>
            'Nama peserta didik wajib diisi.',

            'student_name.max' =>
            'Nama peserta didik maksimal 50 karakter.',

            'student_gender_id.required' =>
            'Jenis kelamin peserta didik wajib dipilih.',

            'student_gender_id.exists' =>
            'Jenis kelamin peserta didik tidak valid.',


            'parent_id.exists' =>
            'Data orang tua yang dipilih tidak ditemukan.',

            'parent_name.required' =>
            'Nama orang tua wajib diisi.',

            'parent_name.max' =>
            'Nama orang tua maksimal 50 karakter.',

            'parent_gender_id.required_without' =>
            'Jenis kelamin orang tua wajib dipilih.',

            'parent_gender_id.exists' =>
            'Jenis kelamin orang tua tidak valid.',

            'parent_address.required_without' =>
            'Alamat orang tua wajib diisi.',

            'parent_telephone.required_without' =>
            'Nomor telepon orang tua wajib diisi.',

            'parent_email.email' =>
            'Format email orang tua tidak valid.',
        ];
    }
}
