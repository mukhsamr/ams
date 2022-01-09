<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentVersionSpiritual extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class, 'student_version_id');
    }
}
