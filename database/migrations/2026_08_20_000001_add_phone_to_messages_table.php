<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('phone_country_iso', 2)->nullable()->after('email');
            $table->string('phone_country_code', 5)->nullable()->after('phone_country_iso');
            $table->string('phone_number', 20)->nullable()->after('phone_country_code');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['phone_country_iso', 'phone_country_code', 'phone_number']);
        });
    }
};