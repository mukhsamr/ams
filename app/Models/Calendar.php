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
    protected $cast = [
        'is_holiday' => 'boolean'
    ];

    protected static function booted()
    {
        static::addGlobalScope(fn ($q) => $q->orderBy('start'));
    }

    public function getFormatStartAttribute()
    {
        return Carbon::parse($this->start)->translatedFormat('l, d F Y');
    }

    public function getFormatIsHolidayAttribute()
    {
        return check_x($this->is_holiday);
    }

    public static function isHoliday($date, $setting)
    {
        $weekend = [
            'sat' => $setting->sat,
            'sun' => $setting->sun,
        ];

        $calendar = self::where('is_holiday', true)->pluck('summary', 'start');
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
