<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('nama'));
    }

    public function getNamaAttribute($value)
    {
        return str_replace(' ', '&nbsp;', ucwords(strtolower($value)));
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public static function getColumns()
    {
        return array_slice(Schema::getColumnListing((new self)->getTable()), 1, -2);
    }
}
