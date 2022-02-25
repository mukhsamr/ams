<?php

use App\Models\School;
use Carbon\Carbon;
use Illuminate\Support\Str;

function scoreColor($type, $score, $kkm)
{
    if ($type == 'rata_rata' || $type == 'nilai_akhir') {
        return ($score < $kkm) ? 'text-danger fw-bold' : 'text-success fw-bold';
    } elseif ($type == 'nilai_bc') {
        return ($score < $kkm) ? 'text-danger fw-bold' : 'text-primary fw-bold';
    } else {
        return ($score < $kkm) ? 'text-warning fw-bold' : '';
    }
};

function ledgerColor($score, $kkm)
{
    return ($score < $kkm) ? 'text-warning fw-bold' : '';
};

function checked($cond)
{
    return $cond ? 'checked' : null;
}

function selected($cond)
{
    return $cond ? 'selected' : null;
}

function disabled($cond)
{
    return $cond ? 'disabled' : null;
}

function check_x($cond)
{
    return boolval($cond) ? '<i data-feather="check" class="text-success"></i>' : '<i data-feather="x" class="text-danger"></i>';
}

function hidden($cond)
{
    return boolval($cond) ? 'hidden' : null;
}

function competence($obj)
{
    return $obj->type == 1 ? "3.{$obj->competence}" : "4.{$obj->competence}";
}

function active($cond)
{
    return $cond ? 'active' : null;
}

function attendanceColor($cond)
{
    $color = [
        'tanpa_keterangan' => 'secondary',
        'tepat_waktu' => 'success',
        'terlambat' => 'warning',
        'izin' => 'info',
        'sakit' => 'primary',
        'alpha' => 'danger'
    ];

    return $color[Str::snake($cond)];
}

function formatDate($date)
{
    return Carbon::parse($date)->translatedFormat('l, d F Y');
}

function predicate($predicate)
{
    $status = [
        'A' => 'Sangat Baik',
        'B' => 'Baik',
        'C' => 'Cukup',
        'D' => 'Perlu dimaksimalkan'
    ];

    return $status[$predicate];
}

function homeColor($score, $kkm)
{
    if ($score) {
        return $score < $kkm ? 'text-warning fw-bold' : null;
    }
}

function tuntasColor($score)
{
    if ($score < 30) {
        return 'text-danger';
    } elseif ($score < 60) {
        return 'text-warning';
    } else {
        return 'text-success';
    }
    return $score;
}

function ordinal($number)
{
    $formatter = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
    return Str::remove($number, $formatter->format($number));
}

function school()
{
    return School::first();
}

function toRoman($number)
{
    $map = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    ];

    $return = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if ($number >= $int) {
                $number -= $int;
                $return .= $roman;
                break;
            }
        }
    }
    return $return;
}
