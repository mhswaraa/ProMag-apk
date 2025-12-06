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
    Schema::create('daily_activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('attendance_id')->constrained()->onDelete('cascade');
        $table->enum('type', ['learning', 'execution']); // Materi vs Praktek
        $table->string('title');
        $table->text('description')->nullable();
        $table->integer('duration_minutes')->nullable(); // Estimasi durasi
        $table->string('tags')->nullable(); // misal: #laravel, #frontend
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
