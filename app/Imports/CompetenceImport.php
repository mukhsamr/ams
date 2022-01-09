<?php

namespace App\Imports;

use App\Models\Competence;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class CompetenceImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError, SkipsEmptyRows
{
    use Importable, SkipsErrors, SkipsFailures;

    private $subject;
    private $grade;
    private $type;
    private $version;
    private $total = 0;
    private $success = 0;

    public function __construct($request)
    {
        $this->subject = $request->subject_id;
        $this->grade = $request->grade_id;
        $this->version = session('version')->id;
    }

    public function model(array $row)
    {
        ++$this->success;
        return new Competence([
            'competence'    => $row['kompetensi'],
            'value'         => $row['kompetensi_dasar'],
            'summary'       => $row['deskripsi'],
            'kkm'           => $row['kkm'],
            'subject_id'    => $this->subject,
            'grade_id'      => $this->grade,
            'type'          => $this->type,
            'version_id'    => $this->version
        ]);
    }

    public function prepareForValidation($data, $index)
    {
        ++$this->total;

        $data['type'] = array_search(substr($data['kompetensi'], 0, 2), ['1' => '3.', '2' => '4.']);
        $data['kompetensi'] = Str::after($data['kompetensi'], '.');

        $this->type = $data['type'];
        return $data;
    }

    public function rules(): array
    {
        return [
            '*.kompetensi' => ['required', 'unique:competences,competence,NULL,id,grade_id,' . $this->grade . ',subject_id,' . $this->subject . ',type,' . $this->type . ',version_id,' . $this->version],
            '*.ringkasan' => 'max:150',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kompetensi.unique' => ':attribute sudah ada.',
        ];
    }

    public function getRowCount($index): string
    {
        $array = [
            'total'     => $this->total,
            'success'   => $this->success,
        ];

        return $array[$index];
    }
}
