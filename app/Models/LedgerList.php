<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LedgerList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = '';

    public $timestamps = false;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function studentVersion()
    {
        return $this->belongsTo(StudentVersion::class, 'student_version_id', 'id');
    }

    public function getPREAttribute($value)
    {
        $color = $value == 'A' ? 'primary' : ($value == 'B' ? 'success' : ($value == 'C' ? 'warning' : 'danger'));
        return '<strong class="text-' . $color . '">' . $value . '</strong>';
    }

    public function getFieldsLedger($type)
    {
        $fields = Schema::getColumnListing($this->table);

        $diff = $type == 1 ? ['id', 'student_version_id', 'rph', 'pas', 'hpa', 'pre', 'deskripsi'] : ['id', 'student_version_id', 'rph', 'pre', 'deskripsi'];

        return collect($fields)->diff($diff);
    }

    public function getRPH($row)
    {
        $avg = collect($row)->avg();
        return $avg !== null ? $avg : null;
    }

    public function getHPA($rph, $pas)
    {
        if ($rph && $pas) {
            return ceil(($rph * (60 / 100) + $pas * (40 / 100))) ?: null;
        }
    }

    public function getPRE($value, $kkm)
    {
        if ($value) {
            $interval = (100 - $kkm) / 3;
            if ($value >= 100 - $interval) {
                return 'A';
            } elseif ($value >= 100 - $interval * 2) {
                return 'B';
            } elseif ($value >= 100 - $interval * 3) {
                return 'C';
            } else {
                return 'D';
            }
        }
    }

    public function prefixDeskripsi($value, $kkm)
    {
        if ($value) {
            $interval = (100 - $kkm) / 3;
            if ($value >= 100 - $interval) {
                return 'sangat baik';
            } elseif ($value >= 100 - $interval * 2) {
                return 'baik';
            } elseif ($value >= 100 - $interval * 3) {
                return 'cukup';
            } else {
                return 'perlu dimaksimalkan';
            }
        }
    }

    public function getDeskripsi($scores, $competences, $kkm)
    {
        if ($scores) {
            $array = $scores->toArray();

            $max = max($array);
            $min = min($array);
            $keyMax = str_replace('_', '.', array_search($max, $array));
            $keyMin = str_replace('_', '.', array_search($min, $array));

            $summary = $competences->pluck('summary', 'format_competence')->toArray();

            $descMax = $this->prefixDeskripsi($max, $kkm) . ' dalam ' . $summary[$keyMax];
            $descMin = $this->prefixDeskripsi($min, $kkm) . ' dalam ' . $summary[$keyMin];

            if ($max !== null && $min !== null) {
                return $descMax . ', ' . $descMin;
            }
        }
    }

    public function updateColumns(array $insert, $type, $competences)
    {
        $kkm = $competences->avg('kkm');
        $fields = $this->getFieldsLedger($type);

        if ($deleted = array_diff($fields->toArray(), array_keys($insert))) {
            Schema::table($this->table, fn (Blueprint $table) => $table->dropColumn(str_replace('.', '_', $deleted)));
        }
        foreach ($insert as $column => $values) {
            if (!Schema::hasColumn($this->table, $column)) {
                Schema::table($this->table, fn (Blueprint $table) => $table->float($column)->nullable()->after($fields->last() ?: 'student_version_id'));
            }
            foreach ($values as $id => $value) {
                try {
                    $this->where('student_version_id', $id)->update([$column => $value]);

                    $row = $this->where('student_version_id', $id);
                    $scores = $row->first($fields->toArray());

                    $rph = $this->getRPH($scores);
                    if ($type == '1') {
                        $hpa = $this->getHPA($rph, $row->value('pas'));
                        $pre = $this->getPRE($hpa, $kkm);
                        $update = [
                            'rph' => $rph,
                            'hpa' => $hpa,
                            'pre' => $pre,
                            'deskripsi' => $this->getDeskripsi($scores, $competences, $kkm)
                        ];
                    } else {
                        $pre = $this->getPRE($rph, $kkm);
                        $update = [
                            'rph' => $rph,
                            'pre' => $pre,
                            'deskripsi' => $this->getDeskripsi($scores, $competences, $kkm)
                        ];
                    }

                    $row->update($update);
                } catch (\Exception $e) {
                    report($e);
                }
            }
        }
    }

    public function getColumns()
    {
        return array_slice(Schema::getColumnListing($this->table), 2);
    }
}
