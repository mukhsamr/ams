<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personality extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function studentVersions()
    {
        return $this->belongsToMany(StudentVersion::class, 'student_version_personalities');
    }
}
