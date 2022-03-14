<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'is_swapped' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
        static::addGlobalScope(function ($query) {
            $query->orderBy('date', 'desc')
                ->orderBy('jam_ke')
                ->orderBy('sub_grade_id')
                ->orderBy('subject_id')
                ->orderBy('tm')
                ->orderBy('competence_id');
        });
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('l, d F Y');
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ===

    public function scopeJoinFilter($query, $start = null, $end = null)
    {
        $query
            ->select('journals.*', 'teachers.nama', 'competences.competence', 'competences.type', 'sub_grades.sub_grade', 'subjects.subject')
            ->join('users', 'users.id', 'journals.user_id')
            ->join('teachers', 'teachers.id', 'users.userable_id')
            ->join('subjects', 'subjects.id', 'journals.subject_id')
            ->join('sub_grades', 'sub_grades.id', 'journals.sub_grade_id')
            ->join('competences', 'competences.id', 'journals.competence_id');

        if ($start) $query->whereDate('date', '>=', $start);
        if ($end) $query->whereDate('date', '<=', $end);

        return $query;
    }
}
