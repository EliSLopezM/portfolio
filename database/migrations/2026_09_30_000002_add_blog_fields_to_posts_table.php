<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('author')->default('Eli Santiago López Mahecha')->after('category');
            $table->string('video_url')->nullable()->after('cover_image');
            $table->string('video_path')->nullable()->after('video_url');
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 170)->nullable();
            $table->string('keywords')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes')->default(0);
            $table->index(['published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['published', 'published_at']);
            $table->dropColumn(['author', 'video_url', 'video_path', 'meta_title', 'meta_description', 'keywords', 'views', 'likes']);
        });
    }
};
