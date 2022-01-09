<?php

namespace App\Imports;

use App\Models\Teacher;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TeacherImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError, SkipsEmptyRows
{
    use Importable, SkipsErrors, SkipsFailures;

    private $total = 0;
    private $success = 0;

    public function model(array $row)
    {
        ++$this->success;
        $data = [];
        $combined = array_combine(array_keys($row), array_slice(Teacher::getColumns(), 0, -1));
        foreach ($combined as $key => $column) {
            $data[$column] = $row[$key];
        }
        return new Teacher($data);
    }

    public function rules(): array
    {
        return [
            '*.email' => "nullable|email:rfc|unique:teachers,email",
            '*.no_ktp' => "nullable|unique:teachers,no_ktp",
        ];
    }

    public function prepareForValidation($data, $index)
    {
        ++$this->total;

        $data['tanggal_lahir'] = $data['tanggal_lahir'] ? $this->transformDate($data['tanggal_lahir'])->toDateString() : null;
        $data['mulai_bekerja'] = $data['mulai_bekerja'] ? $this->transformDate($data['mulai_bekerja'])->toDateString() : null;
        return $data;
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }

    public function customValidationMessages()
    {
        return [
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan, coba yang lain',
            'no_ktp.unique' => 'Nomor KTP sudah digunakan, coba yang lain',
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
