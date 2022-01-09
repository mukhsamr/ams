<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_socials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_version_id')->constrained('student_versions')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('social_id')->nullable();
            $table->string('comment')->nullable();
            $table->enum('predicate', ['A', 'B', 'C', 'D'])->nullable();

            $table->foreign('social_id')->references('id')->on('socials')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('student_socials');
    }
}
