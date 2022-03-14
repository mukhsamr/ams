<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGrade extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(fn ($q) => $q->orderBy('sub_grade'));
    }

    public function guardian()
    {
        return $this->hasMany(Guardian::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function studentVersion()
    {
        return $this->hasMany(StudentVersion::class);
    }

    // ===

    public function scopeWithUser($query, $user_id)
    {
        return $query->addSelect([
            'user_id' => SubGradeUser::select('user_id')
                ->whereColumn('sub_grade_user.sub_grade_id', 'sub_grades.id')
                ->where('sub_grade_user.user_id', $user_id)
                ->limit(1),
        ]);
    }
}
