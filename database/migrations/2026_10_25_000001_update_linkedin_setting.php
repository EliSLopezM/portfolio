<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const URL = 'https://www.linkedin.com/in/eli-santiago-lopez-mahecha-56a9861b9/';

    public function up(): void
    {
        // El enlace guardado desde el dashboard tiene prioridad sobre config/portfolio.php: se unifica aquí.
        if (Schema::hasTable('settings')) {
            Setting::updateOrCreate(['key' => 'linkedin'], ['value' => self::URL]);
        }
    }

    public function down(): void
    {
        // Sin reversa: el valor anterior no se conserva.
    }
};
