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

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public static function getColumns()
    {
        return array_slice(Schema::getColumnListing((new self)->getTable()), 1, -2);
    }

    public function competence()
    {
        return $this->hasMany(Competence::class);
    }

    // ===

    public function scopeWithUser($query, $user_id)
    {
        return $query->addSelect([
            'user_id' => SubjectUser::select('user_id')
                ->whereColumn('subject_user.subject_id', 'subjects.id')
                ->where('subject_user.user_id', $user_id)
                ->limit(1),
        ]);
    }

    public function scopeWithKKM($query)
    {
        return $query->addSelect([
            'kkm3' => Competence::selectRaw('CEIL(AVG(kkm)) avg')
                ->whereColumn('subject_id', 'subjects.id')
                ->where('type', 1),
            'kkm4' => Competence::selectRaw('CEIL(AVG(kkm)) avg')
                ->whereColumn('subject_id', 'subjects.id')
                ->where('type', 2),
        ]);
    }
}
