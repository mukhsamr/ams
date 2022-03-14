<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('nama'));
    }

    public function getNamaAttribute($value)
    {
        return str_replace(' ', '&nbsp;', $value);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function attendance()
    {
        return $this->morphOne(Attendance::class, 'userable');
    }

    public function studentVersion()
    {
        return $this->hasMany(StudentVersion::class);
    }

    public function studentNote()
    {
        return $this->hasManyThrough(StudentNote::class, StudentVersion::class, 'student_id', 'student_version_id', 'id', 'id');
    }

    public static function getColumns()
    {
        return array_slice(Schema::getColumnListing((new self)->getTable()), 1, -2);
    }
}
