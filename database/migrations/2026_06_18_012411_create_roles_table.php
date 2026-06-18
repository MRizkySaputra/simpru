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
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // 'Admin', 'Mahasiswa', dll
        $table->string('icon')->default('person');
        $table->string('color')->default('blue');
        $table->text('description')->nullable();
        $table->json('permissions')->nullable(); // Menyimpan hak akses dalam format JSON
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
