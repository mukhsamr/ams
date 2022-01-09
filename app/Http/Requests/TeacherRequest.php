<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'email' => "nullable|email:rfc|unique:teachers,email,$this->id,id",
            'no_ktp' => "nullable|unique:teachers,no_ktp,$this->id,id",
            'file' => 'image|size:1024'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan, coba yang lain',
            'no_ktp.unique' => 'Nomor KTP sudah digunakan, coba yang lain',
            'file.image' => 'File bukan gambar',
            'file.size' => 'Ukuran gambar terlalu besar',
        ];
    }
}
