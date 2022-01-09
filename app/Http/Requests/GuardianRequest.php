<?php

namespace App\Http\Requests;

use App\Models\Version;
use Illuminate\Foundation\Http\FormRequest;

class GuardianRequest extends FormRequest
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
            'sub_grade_id' => ['required', "unique:guardians,user_id,{$this->id},id,sub_grade_id,{$this->sub_grade_id},version_id,{$this->version_id}"],
            'signature' => 'image',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'version_id' => session('version')->id,
        ]);
    }

    public function messages()
    {
        return [
            'sub_grade_id.required' => 'Harus diisi.',
            'sub_grade_id.unique' => 'Kelas sudah ada.',
            'signature.image' => 'Format harus gambar.',
        ];
    }
}
