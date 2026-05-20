<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('slug');
            $table->string('author')->nullable()->after('thumbnail');
            $table->text('excerpt')->nullable()->after('content');
            $table->json('categories')->nullable()->after('excerpt');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn(['thumbnail', 'author', 'excerpt', 'categories']);
        });
    }
};
