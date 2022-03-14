<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->date('date');
            $table->unsignedInteger('subject_id');
            $table->smallInteger('tm');
            $table->smallInteger('jam_ke');
            $table->unsignedInteger('sub_grade_id');
            $table->foreignId('competence_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->string('matter');
            $table->boolean('is_swapped')->nullable();
            $table->unsignedInteger('version_id');

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('sub_grade_id')->references('id')->on('sub_grades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('journals');
    }
}
