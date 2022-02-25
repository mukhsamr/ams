<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScoreList extends Model
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
        return $this->belongsTo(StudentVersion::class, 'student_version_id');
    }

    public function withStudents()
    {
        return $this->addSelect([
            'student_id' => StudentVersion::select('student_id')
                ->whereColumn('id', $this->getTable() . '.student_version_id')
                ->limit(1),
            'nama' => Student::select('nama')
                ->whereColumn('id', 'student_id')
                ->limit(1),
        ])->orderBy('nama');
    }

    public function scopeWithList($query, $score, $name)
    {
        $table = $score->name;
        $competence = competence($score);
        $column = $score->type == 1 ? 'nilai_bc' : 'nilai_akhir';

        return $query->addSelect("$table.$column as $competence")
            ->join($table, $table . '.student_version_id', '=', $name . '.student_version_id');
    }

    // ===

    public function getFieldsScore($type, $fields = null)
    {
        $fields ??= Schema::getColumnListing($this->table);

        $diff = $type == 1 ? ['id', 'student_version_id', 'rata_rata', 'nilai', 'r1', 'r2', 'nilai_akhir', 'nilai_bc', 'keterangan'] : ['id', 'student_version_id', 'nilai_akhir', 'keterangan'];

        return collect($fields)->diff($diff);
    }

    public function getColumn($column)
    {
        if (Schema::hasColumn($this->table, $column)) {
            return $this->get(['student_version_id', $column]);
        } else {
            return $this->get('student_version_id');
        }
    }

    public function getStatusAttribute()
    {
        $value = $this->keterangan;
        if ($value !== null) return $value ? '<strong class="text-success">Tuntas</strong>' : '<strong class="text-danger">Tidak&nbsp;Tuntas</strong>';
    }

    public function getCompetence()
    {
        return Score::firstWhere('name', $this->table)->competence;
    }

    public function getRataRata($row)
    {
        $avg = collect($row)->avg();
        return $avg !== null ? ceil($avg) : null;
    }

    public function getNilaiAkhir($nilai, $kkm)
    {
        if ($nilai['nilai'] >= $kkm) {
            return $nilai['nilai'];
        } elseif ($nilai['r1'] >= $kkm) {
            return $kkm;
        } elseif ($nilai['r2'] >= $kkm) {
            return $kkm;
        } else {
            return max($nilai);
        }
    }

    public function getNilaiBc($rata2, $nilaiAkhir)
    {
        if ($rata2 !== null && $nilaiAkhir !== null) {
            return ($rata2 * (60 / 100) + $nilaiAkhir * (40 / 100)) ?: null;
        }
    }

    public function updateScores(array $scores, $column, $type)
    {
        $fields = $this->getFieldsScore($type);
        if (!Schema::hasColumn($this->table, $column)) {
            Schema::table($this->table, fn (Blueprint $table) => $table->float($column)->nullable()->after($fields->last() ?: 'student_version_id'));
            $fields = $this->getFieldsScore($type);
        }
        $kkm = $this->getCompetence()->kkm;

        foreach ($scores as $id => $score) {
            try {
                $this->where('student_version_id', $id)->update([$column => $score]);
                if ($columns = $fields->toArray()) {
                    $row = $this->where('student_version_id', $id);
                    $rata2 = $this->getRataRata($row->first($columns)->getAttributes());
                    if ($type == 1) {
                        $update['rata_rata'] = $rata2;
                        $nilaiAkhir = $this->getNilaiAkhir($row->first(['nilai', 'r1', 'r2'])->getAttributes(), $kkm);
                        $update['nilai_akhir'] = $nilaiAkhir;
                        $update['nilai_bc'] = $this->getNilaiBc($rata2, $nilaiAkhir);
                        $update['keterangan'] = $update['nilai_bc'] !== null ? $update['nilai_bc'] >= $kkm : null;
                    } else {
                        $update['nilai_akhir'] = $rata2;
                        $update['keterangan'] = $update['nilai_akhir'] !== null ? $update['nilai_akhir'] >= $kkm : null;
                    }

                    $this->where('student_version_id', $id)->update($update);
                }
                $status[] = true;
            } catch (\Exception $e) {
                report($e);
                $status[] = false;
            }
        }
        return $status;
    }

    public function removeColumn($column, $type)
    {
        Schema::table($this->table, fn (Blueprint $table) => $table->dropColumn($column));

        $fields = $this->getFieldsScore($type);
        $kkm = $this->getCompetence()->kkm;
        try {
            $columns = $fields->toArray();
            foreach ($this->get() as $row) {
                if ($columns) {
                    $rata2 = $this->getRataRata($row->only($columns));
                    if ($type == 1) {
                        $update['rata_rata'] = $rata2;
                        $nilaiAkhir = $this->getNilaiAkhir($row->only(['nilai', 'r1', 'r2']), $kkm);
                        $update['nilai_akhir'] = $nilaiAkhir;
                        $update['nilai_bc'] = $this->getNilaiBc($rata2, $nilaiAkhir);
                        $update['keterangan'] = $update['nilai_bc'] !== null ? $update['nilai_bc'] >= $kkm : null;
                    } else {
                        $update['nilai_akhir'] = $rata2;
                        $update['keterangan'] = $update['nilai_akhir'] !== null ? $update['nilai_akhir'] >= $kkm : null;
                    }
                } else {
                    $update = $type == 1 ? [
                        'rata_rata' => null,
                        'nilai_akhir' => null,
                        'nilai_bc' => null,
                        'keterangan' => null
                    ] : [
                        'nilai_akhir' => null,
                        'keterangan' => null
                    ];
                }
                $status[] = true;

                $this->where('id', $row->id)->update($update);
            }
            return $status;
        } catch (\Exception $e) {
            report($e);
            $status[] = false;
        }

        return $status;
    }

    public static function dropTable($table)
    {
        try {
            Schema::dropIfExists($table);
            return true;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}
