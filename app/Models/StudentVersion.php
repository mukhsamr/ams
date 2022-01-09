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

    public function spiritual()
    {
        return $this->belongsToMany(Spiritual::class, 'student_version_spirituals');
    }

    public function studentSpiritual()
    {
        return $this->hasMany(StudentSpiritual::class);
    }

    public function social()
    {
        return $this->belongsToMany(Social::class, 'student_version_socials');
    }

    public function studentSocial()
    {
        return $this->hasMany(StudentSocial::class);
    }
}
