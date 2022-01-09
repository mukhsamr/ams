<?php

namespace App\Http\Requests;

use App\Models\Student;
use App\Models\Version;
use Illuminate\Foundation\Http\FormRequest;

class StudentVersionRequest extends FormRequest
{
    private $version;

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
            'student.*.student_id' => 'unique:student_versions,student_id,' . $this->id . ',id,version_id,' . $this->version . ''
        ];
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->student as $key => $student) {
            $name = Student::find($student['student_id'])->nama;
            $messages['student.' . $key . '.student_id.unique'] = "Siswa $name sudah ada";
        }
        return $messages;
    }

    protected function prepareForValidation()
    {
        if ($this->student_id) {
            $version = session('version')->id;
            $this->version = $version;
            $this->request->replace(['student' => array_map(fn ($v) => ['student_id' => $v, 'sub_grade_id' => $this->sub_grade_id, 'version_id' => $version], $this->student_id)]);
        } else {
            $this->request->replace(['student' => []]);
        }
    }
}
