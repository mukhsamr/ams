<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'start' => "unique:calendars,start,$this->id,id"
        ];
    }

    public function messages()
    {
        return [
            'start.unique' => 'Event tanggal sudah ada'
        ];
    }
}
