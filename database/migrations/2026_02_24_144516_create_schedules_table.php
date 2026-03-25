<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('day'); // Senin, Selasa, Rabu, Kamis, Jumat
            $table->string('subject'); // Nama mata pelajaran
            $table->string('teacher'); // Nama guru
            $table->string('room'); // Ruang kelas
            $table->time('start_time'); // Jam mulai
            $table->time('end_time'); // Jam selesai
            $table->string('class')->nullable(); // Kelas (X, XI, XII)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
