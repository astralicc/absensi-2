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
    Schema::create('announcements', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('content');
      $table->string('category')->default('umum'); // akademik, umum, kegiatan
      $table->string('priority')->default('low'); // high, medium, low
      $table->string('author');
      $table->date('date');
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    // Table to track which users have read which announcements
    Schema::create('announcement_reads', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->foreignId('announcement_id')->constrained()->onDelete('cascade');
      $table->timestamp('read_at');
      $table->timestamps();

      // Prevent duplicate reads
      $table->unique(['user_id', 'announcement_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('announcement_reads');
    Schema::dropIfExists('announcements');
  }
};
