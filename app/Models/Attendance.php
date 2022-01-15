<?php

namespace App\Models;

use App\Scopes\VersionScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new VersionScope);
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('l, d F Y');
    }

    public function getFormatStatusAttribute()
    {
        $color = [
            'tanpa_keterangan' => 'secondary',
            'tepat_waktu' => 'success',
            'terlambat' => 'warning',
            'izin' => 'info',
            'sakit' => 'primary',
        ];

        $status = $this->status ?? 'Tanpa Keterangan';
        return '<span class="badge rounded-pill bg-' . $color[Str::snake($status)] . '">' . $status . '</span>';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
