<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreColumn extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(strtolower($name));
    }

    public static function getNameOnly($type)
    {
        return self::where('type', $type)->pluck('name');
    }
}
