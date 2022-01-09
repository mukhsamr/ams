<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('sub_grade_id');
            $table->unsignedInteger('type');
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
        Schema::dropIfExists('ledgers');
    }
}
