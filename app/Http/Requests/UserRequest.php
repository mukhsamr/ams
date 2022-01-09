<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'unique:users,username,' . $this->id . ',id',
            'password' => 'min:5',
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => 'Username sudah ada, coba yang lain',
            'password.min' => 'Password terlalu pendek',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->change) $this->merge(['password' => 'Annahl123*']);
    }
}
