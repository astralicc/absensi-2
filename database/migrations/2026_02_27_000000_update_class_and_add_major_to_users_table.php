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
        Schema::table('users', function (Blueprint $table) {
            // Change class to enum
            $table->dropColumn('class');
            $table->enum('class', ['X', 'XI', 'XII'])->nullable()->after('address');

            // Add jurusan (major)
            $table->enum('jurusan', ['RPL', 'BR', 'AKL', 'MP'])->nullable()->after('class');

            // Add fields for wali kelas
            $table->enum('kelas_wali', ['X', 'XI', 'XII'])->nullable()->after('jurusan');
            $table->enum('jurusan_wali', ['RPL', 'BR', 'AKL', 'MP'])->nullable()->after('kelas_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'kelas_wali', 'jurusan_wali']);
            $table->string('class')->nullable()->after('address');
        });
    }
};
