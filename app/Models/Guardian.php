<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subGrade()
    {
        return $this->belongsTo(SubGrade::class);
    }
}
