<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Archivos subidos desde el dashboard: viven en la base de datos (base64) para no perderse
        // en despliegues con disco efímero.
        Schema::create('stored_files', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('folder', 40)->nullable();
            $table->string('mime', 100);
            $table->unsignedInteger('size');
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->longText('data');
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('video_path'); // los videos se enlazan desde YouTube/Vimeo
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('video_path')->nullable()->after('video_url');
        });
        Schema::dropIfExists('stored_files');
    }
};
