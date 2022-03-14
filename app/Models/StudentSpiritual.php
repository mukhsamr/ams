<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSpiritual extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class);
    }

    public function spiritual()
    {
        return $this->belongsTo(Spiritual::class);
    }

    public function scopeWithStudent($query)
    {
        return $query->addSelect([
            'student_id' => StudentVersion::select('student_id')
                ->whereColumn('id', 'student_spirituals.student_version_id')
                ->limit(1),
            'nama' => Student::select('nama')
                ->whereColumn('id', 'student_id')
                ->limit(1),
        ]);
    }

    public function scopeWithSpiritual($query)
    {
        return $query->addSelect([
            'spiritual' => Spiritual::select('list')
                ->whereColumn('id', 'student_spirituals.spiritual_id')
                ->limit(1),
        ]);
    }

    public function scopeWithSpirituals($query)
    {
        return $query->addSelect([
            'spirituals' => Spiritual::selectRaw("GROUP_CONCAT(list SEPARATOR ',')")
                ->whereHas('studentVersions', function ($query) {
                    return $query->whereColumn('student_versions.id', 'student_spirituals.student_version_id');
                })
                ->limit(1),
        ]);
    }

    public function scopeWithCalled($query)
    {
        $query->addSelect([
            'called' => Note::select('called')->limit(1),
        ]);
    }

    public static function getComment($always, $done)
    {
        return implode(
            '. ',
            [
                'sudah terbiasa ' . Spiritual::whereIn('id', $always)->get('list')->implode('list', ', '),
                'sudah menunjukan ' . Spiritual::where('id', $done)->get('list')->implode('list', ', ')
            ]
        );
    }
}
