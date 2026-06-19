<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'nim_nidn') && Schema::hasColumn('users', 'identity_number')) {
            DB::table('users')
                ->whereNull('identity_number')
                ->whereNotNull('nim_nidn')
                ->update(['identity_number' => DB::raw('nim_nidn')]);
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nim_nidn')) {
                $table->dropColumn('nim_nidn');
            }
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nim_nidn')) {
                $table->string('nim_nidn')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('nim_nidn');
            }
        });
    }
};
