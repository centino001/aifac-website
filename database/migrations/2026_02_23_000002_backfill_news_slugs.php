<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('news', 'slug')) {
            return;
        }
        $rows = DB::table('news')->get();
        foreach ($rows as $row) {
            $slug = $row->slug;
            if ($slug === null || $slug === '') {
                $newSlug = \Str::slug($row->title);
                $base = $newSlug;
                $n = 0;
                while (DB::table('news')->where('slug', $newSlug)->where('id', '!=', $row->id)->exists()) {
                    $n++;
                    $newSlug = $base . '-' . $n;
                }
                DB::table('news')->where('id', $row->id)->update(['slug' => $newSlug]);
            }
        }
    }

    public function down(): void
    {
        // no-op
    }
};
