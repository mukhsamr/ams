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
            'foto' => 'image|max:1024'
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => 'Username sudah ada, coba yang lain',
            'password.min' => 'Password terlalu pendek',
            'foto.image' => 'Ekstensi file tidak valid',
            'foto.max' => 'Ukuran foto terlalu besar',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->ignore && !$this->password) $this->merge(['password' => 'Annahl123*']);
    }
}
