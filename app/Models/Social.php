<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function studentVersions()
    {
        return $this->belongsToMany(StudentVersion::class, 'student_version_socials');
    }
}
