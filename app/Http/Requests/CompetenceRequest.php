<?php

namespace App\Http\Requests;

use App\Models\Version;
use Illuminate\Foundation\Http\FormRequest;

class CompetenceRequest extends FormRequest
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
            'competence' => ['required', 'unique:competences,competence,' . $this->id . ',id,grade_id,' . $this->grade . ',subject_id,' . $this->subject_id . ',type,' . $this->type . ',version_id,' . $this->version_id],
            'summary'   => 'max:75'
        ];
    }

    public function messages()
    {
        return [
            'competence.unique' => 'Kompetensi sudah ada',
            'summary.max' => 'Max deskripsi 75 karakter',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'version_id' => session('version')->id,
        ]);
    }
}
