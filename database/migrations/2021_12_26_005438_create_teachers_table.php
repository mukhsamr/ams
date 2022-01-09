<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique()->nullable();
            $table->string('no_telp')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('no_ktp')->unique()->nullable();
            $table->string('kota_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('alamat_ktp')->nullable();
            $table->string('alamat_domisili')->nullable();
            $table->enum('gol_darah', ['A', 'B', 'O', 'AB'])->nullable();
            $table->enum('status_nikah', ['Belum Menikah', 'Sudah Menikah', 'Janda', 'Duda'])->nullable();
            $table->string('no_kk')->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->string('pekerjaan_pasangan')->nullable();
            $table->string('tempat_bekerja_pasangan')->nullable();
            $table->unsignedSmallInteger('jumlah_anak')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('status_wali')->nullable();
            $table->string('no_telp_wali')->nullable();
            $table->string('ibu_kandung')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('institusi_lulusan')->nullable();
            $table->string('program_studi')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->date('mulai_bekerja')->nullable();
            $table->enum('status_karyawan', ['Kontrak', 'Tetap'])->nullable();
            $table->string('no_bpjs_kesehatan')->nullable();
            $table->string('no_bpjs_ketenagakerjaan')->nullable();
            $table->string('npwp')->nullable();
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('teachers');
    }
}
