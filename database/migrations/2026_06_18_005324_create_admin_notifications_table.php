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
    Schema::create('admin_notifications', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Judul notifikasi
        $table->text('message'); // Isi pesan
        $table->string('type')->default('info'); // Jenis: urgent, maintenance, report, system
        $table->boolean('is_read')->default(false); // Status dibaca/belum
        $table->string('action_link')->nullable(); // Link jika tombol di-klik (opsional)
        $table->string('action_text')->nullable(); // Teks tombol (opsional)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
