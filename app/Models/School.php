<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    public function getLogoAttribute($value)
    {
        return asset('storage/img/core/' . $value);
    }

    public function getSignatureAttribute($value)
    {
        if (!file_exists(asset('storage/img/headmaster/' . $value))) {
            return asset('storage/img/headmaster/' . 'signature.png');
        }
        return asset('storage/img/headmaster/' . $value);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
