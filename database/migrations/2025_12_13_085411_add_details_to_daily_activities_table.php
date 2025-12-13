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
    Schema::table('daily_activities', function (Blueprint $table) {
        $table->text('obstacles')->nullable()->after('description'); // Kendala
        $table->text('improvements')->nullable()->after('obstacles'); // Solusi/Improvement
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_activities', function (Blueprint $table) {
            //
        });
    }
};
