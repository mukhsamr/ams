<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\LedgerList;
use Illuminate\Http\Request;

class RaportController extends Controller
{
    public function ptsPDF(Request $request)
    {
        $ledgers = Ledger::where('sub_grade_id', $request->subGrade)
            ->withSubject()
            ->whereRelation('subject', 'raport', true)
            ->get()
            ->groupBy('subject');

        $raports = [];
        if ($nama = $request->nama) {
            foreach ($ledgers as $subject => $ledger) {
                foreach ($ledger as $l) {
                    $list = new LedgerList($l->name);
                    $column = $list->getFieldsLedger($l->type)->toArray();
                    $score = $list->select($column)
                        ->where('student_version_id', $nama)
                        ->first();

                    $lists[] = $score ? $score->getAttributes() : [];
                }
                $raports[$subject] = collect($lists)->collapse();
            }
        }

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);

        ob_start();
        echo view('exports.raports.pts', [
            'raports' => $raports,
            'columns' => ['1', '2', '3', '4'],
        ]);

        $html = ob_get_contents();
        ob_end_clean();

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
