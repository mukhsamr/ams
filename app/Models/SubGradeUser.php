<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGradeUser extends Model
{
    use HasFactory;

    protected $table = 'sub_grade_user';
    protected $guarded = ['id'];

    public function subGrades()
    {
        return $this->belongsTo(SubGrade::class, 'sub_grade_id', 'id');
    }
}
