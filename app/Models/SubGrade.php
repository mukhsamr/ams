<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGrade extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(fn ($q) => $q->orderBy('sub_grade'));
    }

    public function guardian()
    {
        return $this->hasMany(Guardian::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
