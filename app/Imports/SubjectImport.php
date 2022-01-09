<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError, SkipsEmptyRows
{
    use Importable, SkipsErrors, SkipsFailures;

    private $total = 0;
    private $success = 0;

    public function model(array $row)
    {
        ++$this->success;

        $data = [];
        $combined = array_combine(array_keys($row), Subject::getColumns());
        foreach ($combined as $key => $column) {
            $data[$column] = $row[$key];
        }
        return new Subject($data);
    }

    public function rules(): array
    {
        return [
            '*.nama' => 'unique:subjects,subject'
        ];
    }

    public function prepareForValidation($data, $index)
    {
        ++$this->total;
        return $data;
    }

    public function customValidationMessages()
    {
        return [
            'nama.unique' => 'Nama mata pelajaran sudah ada'
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
