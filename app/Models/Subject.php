<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'raport' => 'boolean',
        'local_content' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }

    public static function getColumns()
    {
        return array_slice(Schema::getColumnListing((new self)->getTable()), 1, -2);
    }
}
