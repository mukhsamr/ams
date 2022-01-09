<?php

namespace App\Models;

use App\Http\Traits\ScoreTrait;
use App\Scopes\VersionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Score extends Model
{
    use HasFactory, ScoreTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function build(array $request)
    {
        $version = session('version')->id;

        array_shift($request);
        $score = '__s_' . $version . '_' . implode('_', $request);

        if (!Schema::hasTable($score)) {
            try {
                Schema::create($score, fn (Blueprint $table) => $this->generate($table, $request['competence']));

                $insert = [
                    'name'          => $score,
                    'subject_id'    => $request['subject'],
                    'sub_grade_id'  => $request['sub_grade'],
                    'competence_id' => $request['competence'],
                    'version_id'    => $version,
                ];

                $this->insert($insert);
                return ['status' => 'success', 'table' => $score];
            } catch (\Throwable $e) {
                report($e);
                Schema::dropIfExists($score);
                return ['status' => 'error', 'message' => $e];
            }
        } else {
            return ['status' => 'warning', 'message' => 'exist'];
        }
    }

    public function subGrade()
    {
        return $this->belongsTo(SubGrade::class);
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }
}
