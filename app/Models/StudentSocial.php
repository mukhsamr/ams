<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSocial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class);
    }

    public function social()
    {
        return $this->belongsTo(Social::class);
    }

    public function scopeWithStudent($query)
    {
        return $query->addSelect([
            'student_id' => StudentVersion::select('student_id')
                ->whereColumn('id', 'student_socials.student_version_id')
                ->limit(1),
            'nama' => Student::select('nama')
                ->whereColumn('id', 'student_id')
                ->limit(1),
        ]);
    }

    public function scopeWithSocial($query)
    {
        return $query->addSelect([
            'social' => Social::select('list')
                ->whereColumn('id', 'student_socials.social_id')
                ->limit(1),
        ]);
    }

    public function scopeWithSocials($query)
    {
        return $query->addSelect([
            'socials' => Social::selectRaw("GROUP_CONCAT(list SEPARATOR ',')")
                ->whereHas('studentVersions', function ($query) {
                    return $query->whereColumn('student_versions.id', 'student_socials.student_version_id');
                })
                ->limit(1),
        ]);
    }

    public function scopeWithCalled($query)
    {
        $query->addSelect([
            'called' => Note::select('called')->limit(1),
        ]);
    }

    public static function getComment($always, $done)
    {
        return implode(
            ' dan untuk sikap ',
            [
                'selalu menunjukan ' . Social::whereIn('id', $always)->get('list')->implode('list', ', '),
                Social::where('id', $done)->get('list')->implode('list', ', ') . ' mengalami peningkatan'
            ]
        );
    }
}
