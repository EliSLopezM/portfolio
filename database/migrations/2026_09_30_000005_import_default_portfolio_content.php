<?php

use App\Services\DefaultContentImporter;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        (new DefaultContentImporter)->import();
    }

    public function down(): void
    {
        // El contenido se conserva: lo elimina el rollback de create_content_tables.
    }
};
