<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('hours')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->string('etc')->nullable();
            $table->unsignedInteger('version_id');
            $table->timestamps();

            $table->unique(['date', 'user_id', 'version_id']);
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
