<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class);
    }

    public function scopeWithStudent($query)
    {
        return $query->addSelect([
            'user_id' => User::select('id')
                ->whereHasMorph('userable', [Student::class], function ($query) {
                    $query->whereHas('studentVersion', function ($query) {
                        $query->whereColumn('id', 'student_version_id');
                    });
                })
                ->limit(1),
            'nama' => Student::select('nama')
                ->whereHas('studentVersion', function ($query) {
                    $query->whereColumn('id', 'student_version_id');
                })
                ->limit(1),
        ]);
    }

    // public function scopeWithAttendance($query)
    // {
    //     return $query
    //         ->addSelect([
    //             'student_id' => StudentVersion::select('student_id')
    //                 ->whereColumn('id', 'notes.student_version_id')
    //                 ->limit(1),
    //             'Tepat Waktu' => Attendance::selectRaw('count(status) as `Tepat Waktu`')
    //                 ->whereColumn('attendances.student_id', 'student_id')
    //                 ->where('status', 'Tepat Waktu')
    //                 ->groupBy('status')
    //         ])
    //         ->selectRaw('count(*) as status')
    //         ->join('attendances', 'attendances.user_id', '=', 'user_id')
    //         ->groupBy('status');
    // }
}
