<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('bookings', 'reject_reason') && Schema::hasColumn('bookings', 'rejection_reason')) {
            DB::table('bookings')
                ->whereNull('rejection_reason')
                ->whereNotNull('reject_reason')
                ->update(['rejection_reason' => DB::raw('reject_reason')]);
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'reject_reason')) {
                $table->dropColumn('reject_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'reject_reason')) {
                $table->text('reject_reason')->nullable()->after('status');
            }
        });
    }
};
