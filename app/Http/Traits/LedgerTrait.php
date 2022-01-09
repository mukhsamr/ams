<?php

namespace App\Http\Traits;

use Illuminate\Database\Schema\Blueprint;

/**
 * Generate score column by competence
 */

trait LedgerTrait
{
    public function generate(Blueprint $table, $type)
    {
        $table->id();
        $table->foreignId('student_version_id')->constrained('student_versions')->onDelete('cascade')->onUpdate('cascade');

        $table->float('rph')->nullable();
        if ($type == 1) {
            $table->float('pas')->nullable();
            $table->float('hpa')->nullable();
        }
        $table->enum('pre', ['A', 'B', 'C', 'D'])->nullable();
        $table->text('deskripsi')->nullable();
    }
}
