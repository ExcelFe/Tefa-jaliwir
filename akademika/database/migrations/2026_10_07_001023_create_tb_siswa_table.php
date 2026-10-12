<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_siswa', function (Blueprint $table) {

            $table->id('id_siswa');

            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('nis')->unique();

            $table->string('nama');

            $table->string('kelas');

            $table->string('jurusan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_siswa');
    }
};