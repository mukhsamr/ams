<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoreRequest extends FormRequest
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
            'name' => 'unique:scores,name,NULL,id,version_id,' . session('version')->id,
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Nilai sudah ada'
        ];
    }
}
