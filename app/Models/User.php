<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [
        'id',
        'created_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getRoleAttribute()
    {
        $role = [
            2 => 'Guru bidang',
            3 => 'Wali kelas',
            4 => 'Operator',
            5 => 'Admin',
        ];
        return $role[$this->level];
    }

    public function getFotoAttribute($value)
    {
        return $value ? 'users/' . $value : $value;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function subjectUsers()
    {
        return $this->hasMany(SubjectUser::class);
    }

    public function subGrades()
    {
        return $this->belongsToMany(SubGrade::class);
    }

    public function competences()
    {
        return $this->hasManyThrough(Competence::class, SubjectUser::class, 'user_id', 'subject_id', 'id', 'subject_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // === 

    public function scores()
    {
        return Score::query()
            ->select('scores.*', 'competences.competence', 'competences.type')
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
            ])
            ->where('subject_user.user_id', $this->id)
            ->where('sub_grade_user.user_id', $this->id)
            ->get();
    }

    public function grades()
    {
        return Grade::query()
            ->select('grades.*')
            ->join('sub_grades', 'sub_grades.grade_id', '=', 'grades.id')
            ->join('sub_grade_user', 'sub_grade_user.sub_grade_id', '=', 'sub_grades.id')
            ->where('sub_grade_user.user_id', $this->id)
            ->distinct()
            ->get();
    }

    // ===

    public function scopeWithTeacher($query)
    {
        return $query
            ->join('teachers', 'teachers.id', '=', 'users.userable_id')
            ->where('userable_type', Teacher::class);
    }

    public function scopeWithStudent($query)
    {
        return $query
            ->join('students', 'students.id', '=', 'users.userable_id')
            ->where('userable_type', Student::class);
    }
}
