<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->json('value')->nullable();
            $table->timestamps();
        });

        Schema::create('stack_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 40)->unique();
            $table->string('name', 60);
            $table->string('description')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('stack_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stack_category_id')->constrained()->cascadeOnDelete();
            $table->string('name', 60);
            $table->string('type', 120)->nullable();
            $table->string('level', 20)->default('dominio'); // dominio | estudio
            $table->text('icon')->nullable();                // URL https, data:image o ruta subida
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company')->nullable();
            $table->string('url')->nullable();
            $table->string('github')->nullable();
            $table->string('image')->nullable();
            $table->json('tags')->nullable();
            $table->text('description');
            $table->json('links')->nullable();
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('platform');
            $table->string('year', 4);
            $table->string('pdf')->nullable();
            $table->string('preview')->nullable();
            $table->string('category', 20)->default('curso'); // destacado | curso
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('scope', 20); // dcc | develop
            $table->string('title')->nullable();
            $table->string('alt')->nullable();
            $table->string('path');
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
            $table->index(['scope', 'visible', 'position']);
        });

        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type', 20)->default('especial'); // especial | reunion | actividad
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->string('starts_at', 5)->nullable();
            $table->string('location')->nullable();
            $table->boolean('visible')->default(true);
            $table->timestamps();
            $table->index(['visible', 'starts_on']);
        });
    }

    public function down(): void
    {
        foreach (['calendar_events', 'media', 'certificates', 'projects', 'stack_items', 'stack_categories', 'settings'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
