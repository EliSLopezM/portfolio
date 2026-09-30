<?php

namespace App\Console\Commands;

use App\Services\DefaultContentImporter;
use Illuminate\Console\Command;

class ImportPortfolioContent extends Command
{
    protected $signature = 'portfolio:import-defaults {--force : Reemplaza el contenido existente por el de config/portfolio.php}';

    protected $description = 'Importa el contenido inicial del portafolio a la base de datos';

    public function handle(DefaultContentImporter $importer): int
    {
        if ($this->option('force') && ! $this->confirm('Esto reemplaza stack, proyectos y certificados editados en el dashboard. ¿Continuar?')) {
            return self::FAILURE;
        }

        $done = $importer->import((bool) $this->option('force'));
        $this->info($done ? 'Importado: '.implode(', ', $done) : 'No había nada por importar (ya existe contenido).');

        return self::SUCCESS;
    }
}
