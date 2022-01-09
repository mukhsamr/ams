<?php

namespace App\Models;

use App\Http\Traits\LedgerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Ledger extends Model
{
    use HasFactory, LedgerTrait;

    protected $guarded = ['id'];

    public function subGrade()
    {
        return $this->belongsTo(SubGrade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function build(array $request)
    {
        $version = session('version')->id;

        $ledger = '__l_' . $version . '_' . implode('_', $request);

        if (!Schema::hasTable($ledger)) {
            try {
                Schema::create($ledger, fn (Blueprint $table) => $this->generate($table, $request['type']));

                $students = StudentVersion::where('sub_grade_id', $request['sub_grade'])->pluck('id');
                DB::table($ledger)->insert(array_map(fn ($v) => ['student_version_id' => $v], $students->toArray()));

                $insert = [
                    'name'          => $ledger,
                    'subject_id'    => $request['subject'],
                    'sub_grade_id'  => $request['sub_grade'],
                    'type'          => $request['type'],
                    'version_id'    => $version,
                ];
                $this->insert($insert);

                return ['status' => true, 'table' => $ledger];
            } catch (\Throwable $e) {
                report($e);
                Schema::dropIfExists($ledger);
                return ['status' => false, 'message' => $e];
            }
        } else {
            return ['status' => true, 'table' => $ledger];
        }
    }
}
