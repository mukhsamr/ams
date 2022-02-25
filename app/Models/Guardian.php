<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subGrade()
    {
        return $this->belongsTo(SubGrade::class);
    }

    // === 

    public function scopeWithUser($query)
    {
        return $query->addSelect([
            'nama' => Teacher::select('nama')
                ->whereHas('user', function ($query) {
                    $query->whereColumn('users.id', 'guardians.user_id');
                })
                ->limit(1)
        ]);
    }

    public function scopeWithSubGrade($query)
    {
        return $query->addSelect([
            'subGrade' => SubGrade::select('sub_grade')
                ->whereColumn('sub_grades.id', 'guardians.sub_grade_id')
                ->limit(1)
        ]);
    }
}
