<?php

namespace App\Imports;

use App\Models\Competence;
use App\Models\Journal;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JournalImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use Importable, SkipsErrors, SkipsFailures;

    private $user_id;
    private $subject_id;
    private $subGrade_id;
    private $version_id;
    private $total = 0;
    private $success = 0;

    public function __construct($request)
    {
        $this->user_id = $request->user_id;
        $this->subject_id = $request->subject;
        $this->subGrade_id = $request->sub_grade;
        $this->version_id = $request->version_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ++$this->success;
        return new Journal([
            'user_id'   => $this->user_id,
            'date'      => $row['tanggal'],
            'subject_id'    => $this->subject_id,
            'tm'        => $row['tm'],
            'jam_ke'    => $row['jam_ke'],
            'sub_grade_id'  => $this->subGrade_id,
            'competence_id' => $row['kompetensi'],
            'matter'    => $row['materi'],
            'version_id'    => $this->version_id,
        ]);
    }

    public function prepareForValidation($data, $index)
    {
        ++$this->total;
        $explode = explode('.', $data['kompetensi']);
        $type = $explode[0] == '3' ? 1 : 2;
        $competence = Competence::where('competence', $explode[1])->where('type', $type)->where('subject_id', $this->subject_id)->first();

        $data['tanggal'] = $this->transformDate($data['tanggal']);
        $data['kompetensi'] = $competence ? $competence->id : null;
        return $data;
    }

    public function rules(): array
    {
        return [
            '*.kompetensi' => 'exists:competences,id'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kompetensi.exists' => ':attribute tidak valid.',
        ];
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(Date::excelToDateTimeObject($value))->toDateString();
        } catch (\ErrorException $e) {
            try {
                return Carbon::createFromFormat($format, $value)->toDateString();
            } catch (\Throwable $th) {
                return null;
            }
        }
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
