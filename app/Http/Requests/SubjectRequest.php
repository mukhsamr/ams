<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'subject' => "unique:subjects,subject,$this->id,id"
        ];
    }

    public function messages()
    {
        return [
            'subject.unique' => 'Nama mata pelajaran sudah ada'
        ];
    }

    protected function prepareForValidation()
    {
        $this->raport ?? $this->merge(['raport' => null]);
        $this->local_content ?? $this->merge(['local_content' => null]);
    }
}
