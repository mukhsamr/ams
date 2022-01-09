<?php

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
