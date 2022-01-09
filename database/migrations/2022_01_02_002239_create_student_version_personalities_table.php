<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVersionPersonalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_version_personalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_version_id')->constrained('student_versions')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('personality_id');
            $table->foreign('personality_id')->references('id')->on('personalities')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_version_personalities');
    }
}
