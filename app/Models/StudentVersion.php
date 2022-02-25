<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentVersion extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->orderBy('nama');
    }

    public function subGrade()
    {
        return $this->belongsTo(SubGrade::class);
    }

    public function note()
    {
        return $this->hasMany(Note::class);
    }

    public function spirituals()
    {
        return $this->belongsToMany(Spiritual::class, 'student_version_spirituals');
    }

    public function studentSpiritual()
    {
        return $this->hasMany(StudentSpiritual::class);
    }

    public function socials()
    {
        return $this->belongsToMany(Social::class, 'student_version_socials');
    }

    public function studentSocial()
    {
        return $this->hasMany(StudentSocial::class);
    }

    public function ekskuls()
    {
        return $this->belongsToMany(Ekskul::class, 'student_version_ekskuls');
    }

    public function studentEkskul()
    {
        return $this->hasMany(StudentEkskul::class);
    }

    public function personalities()
    {
        return $this->belongsToMany(Personality::class, 'student_version_personalities');
    }

    // ===

    public function scopeWithStudent($query)
    {
        return $query
            ->select('student_versions.*', 'students.nama', 'students.nisn')
            ->join('students', 'students.id', '=', 'student_versions.student_id');
    }
}
