<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sub_grade')->unique();
            $table->string('name');
            $table->unsignedInteger('grade_id');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_grades');
    }
}
