<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];
    protected $hidden   = ['created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
        static::addGlobalScope(fn ($q) => $q->orderBy('competence')->orderBy('type'));
    }

    public function getFormatCompetenceAttribute()
    {
        return $this->type == 1 ? "3.{$this->competence}" : "4.{$this->competence}";
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    // ===

    public function scopeWithUsed($query)
    {
        return $query->addSelect([
            'used' => Score::select('competence_id')
                ->whereColumn('competence_id', 'competences.id')
                ->limit(1)
        ]);
    }

    public function scopeWithGrade($query)
    {
        return $query->addSelect([
            'grade' => Grade::select('grade')
                ->whereColumn('id', 'competences.grade_id')
                ->limit(1)
        ]);
    }
}
