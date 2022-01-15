<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(fn ($q) => $q->orderBy('start'));
    }
    public function getFormatStartAttribute()
    {
        return Carbon::parse($this->start)->translatedFormat('l, d F Y');
    }

    public static function isHoliday($date, $setting = null)
    {
        $setting ??= AttendanceSetting::first();
        $weekend = [
            'sat' => $setting->sat,
            'sun' => $setting->sun,
        ];

        $calendar = self::pluck('summary', 'start');
        if ($weekend[strtolower(date('D', strtotime($date)))] ?? false) {
            return [
                'holiday' => true,
                'event' => 'Weekend'
            ];
        } elseif ($calendar->has($date)) {
            return [
                'holiday' => true,
                'event' => $calendar[$date]
            ];
        } else {
            return false;
        }
    }
}
