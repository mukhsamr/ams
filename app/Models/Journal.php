<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
        static::addGlobalScope(function ($query) {
            $query->orderBy('date', 'desc')
                ->orderBy('sub_grade_id')
                ->orderBy('subject_id')
                ->orderBy('tm')
                ->orderBy('jam_ke')
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
}
