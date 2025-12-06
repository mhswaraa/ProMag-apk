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
    Schema::create('skills', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Nama skill, misal: Laravel
        $table->enum('category', ['hard_skill', 'soft_skill']);
        $table->integer('initial_level')->default(0); // 0-100
        $table->integer('current_level')->default(0); // 0-100
        $table->text('notes')->nullable(); // Bukti/Keterangan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
