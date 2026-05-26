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
    Schema::table('rooms', function (Blueprint $table) {
        // Menambahkan kolom facilities agar bisa menyimpan data fasilitas
        $table->text('facilities')->nullable()->after('capacity');
    });
}

public function down(): void
{
    Schema::table('rooms', function (Blueprint $table) {
        $table->dropColumn('facilities');
    });
}
};
