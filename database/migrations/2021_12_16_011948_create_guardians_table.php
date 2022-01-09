<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->unsignedInteger('sub_grade_id');
            $table->string('signature')->nullable();
            $table->unsignedInteger('version_id');

            $table->foreign('sub_grade_id')->references('id')->on('sub_grades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('restrict')->onUpdate('cascade');

            $table->unique(['user_id', 'sub_grade_id', 'version_id']);
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
        Schema::dropIfExists('guardians');
    }
}
