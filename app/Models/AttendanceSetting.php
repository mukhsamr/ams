<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function student()
    {
        return self::firstWhere('type', 'student');
    }

    public static function teacher()
    {
        return self::firstWhere('type', 'teacher');
    }
}
