<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambah identity_number jika belum ada
            if (!Schema::hasColumn('users', 'identity_number')) {
                $table->string('identity_number')->unique()->nullable()->after('email');
            }
            
            // Cek dan tambah role jika belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('mahasiswa')->after('identity_number');
            }
            
            // Cek dan tambah is_active jika belum ada
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'identity_number')) {
                $table->dropColumn('identity_number');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};