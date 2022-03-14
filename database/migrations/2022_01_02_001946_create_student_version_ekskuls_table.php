<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVersionEkskulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_version_ekskuls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_version_id')->constrained('student_versions')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('ekskul_id');
            $table->foreign('ekskul_id')->references('id')->on('ekskuls')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('predicate', ['A', 'B', 'C', 'D'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_version_ekskuls');
    }
}
