<?php

namespace App\Http\Traits;

use App\Models\Competence;
use Illuminate\Database\Schema\Blueprint;

/**
 * Generate score column by competence
 */

trait ScoreTrait
{
    public function generate(Blueprint $table, $competence)
    {
        $table->id();
        $table->foreignId('student_version_id')->constrained('student_versions')->onDelete('cascade')->onUpdate('cascade');

        if (Competence::find($competence)->type == '1') {
            $table->float('rata_rata')->nullable();
            $table->float('nilai')->nullable();
            $table->float('r1')->nullable();
            $table->float('r2')->nullable();
            $table->float('nilai_akhir')->nullable();
            $table->float('nilai_bc')->nullable();
        } else {
            $table->float('nilai_akhir')->nullable();
        }
        $table->boolean('keterangan')->nullable();
    }
}
