<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('competence');
            $table->enum('type', ['1', '2']);
            $table->string('value');
            $table->string('summary', '150');
            $table->float('kkm');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('version_id');

            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('restrict')->onUpdate('cascade');
            $table->unique(['competence', 'type', 'subject_id', 'grade_id', 'version_id'], 'unique_competence');

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('competences');
    }
}
