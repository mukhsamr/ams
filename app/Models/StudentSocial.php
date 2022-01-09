<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSocial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class);
    }

    public function social()
    {
        return $this->belongsTo(Social::class);
    }

    public function scopeGetSocials($query, $subGrade)
    {
        return $query
            ->with([
                'studentVersion:id,student_id',
                'studentVersion.student:id,nama',
                'studentVersion.social',
                'social'
            ])->whereRelation(
                'studentVersion',
                'sub_grade_id',
                $subGrade->id
            )->get()->sortBy(fn ($q) => $q->studentVersion->student->nama);
    }

    public static function getComment($always, $done)
    {
        return implode(
            ' dan untuk sikap ',
            [
                'selalu menunjukan ' . Social::whereIn('id', $always)->get('list')->implode('list', ', '),
                Social::where('id', $done)->get('list')->implode('list', ', ') . ' mengalami peningkatan'
            ]
        );
    }
}
