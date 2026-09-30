<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->json('statuses')->nullable()->after('mensaje');
            $table->string('ip', 45)->nullable();
            $table->decimal('recaptcha_score', 3, 2)->nullable();
            $table->index('created_at');
        });

        DB::table('messages')->where('leido', true)->update(['statuses' => json_encode(['leido'])]);

        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('leido');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('leido')->default(false);
            $table->dropIndex(['created_at']);
            $table->dropColumn(['statuses', 'ip', 'recaptcha_score']);
        });
    }
};
