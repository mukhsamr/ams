<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class);
    }

    public function scopeGetNotes($query, $subGrade)
    {
        return $query
            ->with([
                'studentVersion:id,student_id',
                'studentVersion.student:id,nama'
            ])->whereRelation(
                'studentVersion',
                'sub_grade_id',
                $subGrade->id
            )->get()->sortBy(fn ($q) => $q->studentVersion->student->nama);
    }
}
