<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_versions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('sub_grade_id');
            $table->unsignedInteger('version_id');

            $table->foreign('sub_grade_id')->references('id')->on('sub_grades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('restrict')->onUpdate('cascade');

            $table->unique(['student_id', 'version_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_versions');
    }
}
