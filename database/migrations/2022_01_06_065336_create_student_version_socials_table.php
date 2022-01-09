<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentVersionSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_version_socials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_version_id')->constrained('student_versions')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('social_id');
            $table->foreign('social_id')->references('id')->on('socials')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_version_socials');
    }
}
