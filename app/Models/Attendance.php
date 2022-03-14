<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('l, d F Y');
    }

    public function getFormatStatusAttribute()
    {
        $status = $this->status ?: 'Tanpa Keterangan';
        return '<span class="badge rounded-pill bg-' . attendanceColor($status) . '">' . $status . '</span>';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // === 

    public function scopeWithStudent($query, $filter)
    {
        return $query
            ->rightJoin('users', function ($join) use ($filter) {
                $join->on('users.id', '=', 'attendances.user_id')
                    ->where('date', $filter);
            })
            ->join('students', 'students.id', '=', 'users.userable_id')
            ->where('userable_type', Student::class)
            ->addSelect([
                'subGrade' => SubGrade::select('sub_grade')
                    ->whereHas('studentVersion', function ($query) {
                        $query->whereColumn('student_id', 'users.userable_id');
                    })
                    ->limit(1)
            ]);
    }

    public function scopeWithTeacher($query, $filter)
    {
        return $query
            ->rightJoin('users', function ($join) use ($filter) {
                $join->on('users.id', '=', 'attendances.user_id')
                    ->where('date', $filter);
            })
            ->join('teachers', 'teachers.id', '=', 'users.userable_id')
            ->where('userable_type', Teacher::class);
    }

    public function scopeWithSubGrade($query, $subGrade)
    {
        return $query
            ->join('student_versions', 'student_versions.student_id', '=', 'users.userable_id')
            ->where('sub_grade_id', $subGrade);
    }
}
