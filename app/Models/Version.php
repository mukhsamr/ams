<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    public $timestamps = false;

    protected $cast = [
        'is_used' => 'boolean'
    ];
}
