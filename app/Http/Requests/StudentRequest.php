<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'nipd' => "unique:students,nipd,$this->id,id",
            'nisn' => "unique:students,nisn,$this->id,id",
            'file' => 'image|size:1024'
        ];
    }

    public function messages()
    {
        return [
            'nipd.unique' => 'NIPD sudah ada',
            'nisn.unique' => 'NISN sudah ada',
            'file.image' => 'File bukan gambar',
            'file.size' => 'Ukuran gambar terlalu besar',
        ];
    }
}
