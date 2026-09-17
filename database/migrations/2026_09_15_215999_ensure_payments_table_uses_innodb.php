<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver !== 'mysql') {
            return;
        }

        $tables = DB::select(
            'SELECT TABLE_NAME AS name FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_TYPE = \'BASE TABLE\'
               AND ENGINE <> \'InnoDB\''
        );

        foreach ($tables as $table) {
            $name = $table->name;
            // Skip internal/system-ish names if any slip through
            if ($name === '' || str_contains($name, '`')) {
                continue;
            }

            DB::statement("ALTER TABLE `{$name}` ENGINE=InnoDB");
        }
    }

    public function down(): void
    {
        // Intentionally empty — InnoDB is required for foreign keys.
    }
};
