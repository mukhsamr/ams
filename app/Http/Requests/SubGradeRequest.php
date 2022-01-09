<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubGradeRequest extends FormRequest
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
            'sub_grade' => "unique:sub_grades,sub_grade,$this->id,id"
        ];
    }

    public function messages()
    {
        return [
            'sub_grade.unique' => 'Sub Kelas sudah ada'
        ];
    }
}
