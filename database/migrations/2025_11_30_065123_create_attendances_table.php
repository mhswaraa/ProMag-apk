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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']);
        $table->time('check_in')->nullable();
        $table->time('check_out')->nullable();
        $table->string('mood')->nullable(); // happy, neutral, sad
        $table->text('notes')->nullable(); // Keterangan izin/catatan harian
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
