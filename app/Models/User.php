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

    public function subject()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function subjectUser()
    {
        return $this->hasMany(SubjectUser::class);
    }

    public function subGrade()
    {
        return $this->belongsToMany(SubGrade::class);
    }

    public function competence()
    {
        return $this->hasManyThrough(Competence::class, SubjectUser::class, 'user_id', 'subject_id', 'id', 'subject_id');
    }

    public function score()
    {
        return $this->hasManyThrough(Score::class, SubjectUser::class, 'user_id', 'subject_id', 'id', 'subject_id');
    }

    public function journal()
    {
        return $this->hasMany(Journal::class);
    }

    public function guardian()
    {
        return $this->hasMany(Guardian::class);
    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function getSubject()
    {
        return $this->subject->pluck('id')->toArray();
    }

    public function getSubGrade()
    {
        return $this->subGrade->pluck('id')->toArray();
    }

    public function getGrade()
    {
        return $this->subGrade->unique('grade_id')->pluck('grade_id')->toArray();
    }

    // 
    public function getCompetence($subject = null, $grade = null)
    {
        $subject = $subject ?: $this->getSubject();
        $grade = $grade ?: $this->getGrade();

        return $this->competence()
            ->with('grade')
            ->whereIn('competences.subject_id', is_array($subject) ? $subject : [$subject])
            ->whereIn('grade_id', is_array($grade) ? $grade : [$grade]);
    }

    public function getJournal($subject = null, $subGrade = null)
    {
        $subject = $subject ?: $this->getSubject();
        $subGrade = $subGrade ?: $this->getSubGrade();

        return $this->journal()
            ->with(['competence.grade', 'subGrade', 'subject'])
            ->whereIn('subject_id', is_array($subject) ? $subject : [$subject])
            ->whereIn('sub_grade_id', is_array($subGrade) ? $subGrade : [$subGrade]);
    }
}
