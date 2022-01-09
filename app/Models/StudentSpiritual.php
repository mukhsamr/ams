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

    public function scopeGetSpirituals($query, $subGrade)
    {
        return $query
            ->with([
                'studentVersion:id,student_id',
                'studentVersion.student:id,nama',
                'studentVersion.spiritual',
                'spiritual'
            ])->whereRelation(
                'studentVersion',
                'sub_grade_id',
                $subGrade->id
            )->get()->sortBy(fn ($q) => $q->studentVersion->student->nama);
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
