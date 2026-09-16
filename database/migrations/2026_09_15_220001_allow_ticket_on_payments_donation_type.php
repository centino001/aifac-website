<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY donation_type VARCHAR(32) NOT NULL DEFAULT 'foundation'");
        }
        // SQLite stores Laravel enums as strings already — no schema change needed.
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::table('payments')
                ->where('donation_type', 'ticket')
                ->update(['donation_type' => 'foundation']);

            DB::statement("ALTER TABLE payments MODIFY donation_type ENUM('foundation', 'project') NOT NULL DEFAULT 'foundation'");
        }
    }
};
