<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEkskul extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class);
    }

    public function scopeWithStudent($query)
    {
        return $query->addSelect([
            'nama' => Student::select('nama')
                ->whereHas('studentVersion', function ($query) {
                    $query->whereColumn('id', 'student_version_id');
                })
                ->limit(1),
        ]);
    }

    public function scopeWithEkskuls($query)
    {
        return $query->addSelect([
            'ekskuls' => Ekskul::selectRaw("GROUP_CONCAT(list)")
                ->whereHas('studentVersions', function ($query) {
                    return $query->whereColumn('student_versions.id', 'student_ekskuls.student_version_id');
                })
                ->limit(1),
            'pre_e' => StudentVersionEkskul::selectRaw("GROUP_CONCAT(predicate)")
                ->whereColumn('student_version_id', 'student_ekskuls.student_version_id')
                ->limit(1),
        ]);
    }

    public function scopeWithPersonalities($query)
    {
        return $query->addSelect([
            'personalities' => Personality::selectRaw("GROUP_CONCAT(list)")
                ->whereHas('studentVersions', function ($query) {
                    return $query->whereColumn('student_versions.id', 'student_ekskuls.student_version_id');
                })
                ->limit(1),
            'pre_p' => StudentVersionPersonality::selectRaw("GROUP_CONCAT(predicate)")
                ->whereColumn('student_version_id', 'student_ekskuls.student_version_id')
                ->limit(1),
        ]);
    }
}
