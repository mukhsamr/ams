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

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function subGrade()
    {
        return $this->belongsTo(SubGrade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    // ===

    public function scopeWithSubject($query)
    {
        return $query->join('subjects', 'subjects.id', 'scores.subject_id');
    }

    public function scopeWithCompetence($query)
    {
        return $query->join('competences', 'competences.id', 'scores.competence_id');
    }

    public function scopeJoinAll($query)
    {
        return $query->select('scores.*', 'competences.competence', 'competences.type')
            ->join('subject_user', 'subject_user.subject_id', '=', 'scores.subject_id')
            ->join('sub_grade_user', 'sub_grade_user.sub_grade_id', '=', 'scores.sub_grade_id')
            ->join('competences', 'competences.id', '=', 'scores.competence_id')
            ->addSelect([
                'subject' => Subject::select('subject')
                    ->whereColumn('id', 'scores.subject_id')
                    ->limit(1),
                'subGrade' => SubGrade::select('sub_grade')
                    ->whereColumn('id', 'scores.sub_grade_id')
                    ->limit(1),
            ]);
    }

    // ===

    public function build(array $request)
    {
        $version = session('version')->id;

        array_shift($request);
        $name = '__s_' . $version . '_' . implode('_', $request);

        if (Schema::hasTable($name)) return ['status' => 'warning'];

        try {
            Schema::create($name, fn (Blueprint $table) => $this->generate($table, $request['competence']));

            $insert = [
                'name'          => $name,
                'subject_id'    => $request['subject'],
                'sub_grade_id'  => $request['sub_grade'],
                'competence_id' => $request['competence'],
                'version_id'    => $version,
            ];

            $this->create($insert);
            return ['status' => 'success', 'name' => $name];
        } catch (\Throwable $th) {
            report($th);
            Schema::dropIfExists($name);
            return ['status' => 'error', 'message' => $th];
        }
    }
}
