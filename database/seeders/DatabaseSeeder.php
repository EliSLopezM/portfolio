<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $posts = [
            [
                'title' => 'Claude en un proyecto: estructura para desarrollar con velocidad y control',
                'category' => 'IA aplicada',
                'excerpt' => 'Una estructura de trabajo con Claude reduce contexto perdido, errores repetidos y cambios difíciles de revisar.',
                'content' => "La productividad con Claude depende más del contexto que del prompt aislado. Separa el proyecto en capas, define un archivo de reglas (CLAUDE.md), documenta comandos reproducibles y trabaja por tareas pequeñas verificables.\n\nEl ciclo recomendado es: especificación breve, exploración del código, implementación mínima, pruebas y revisión del diff. Claude debe recibir contratos, restricciones y criterios de aceptación; no debe decidir secretos, permisos ni cambios destructivos.\n\nCon Git, commits atómicos y tests ejecutables, la IA acelera el desarrollo sin convertir el repositorio en una caja negra.",
            ],
            [
                'title' => 'Estructura correcta de un proyecto web en Laravel',
                'category' => 'Laravel',
                'excerpt' => 'Una arquitectura Laravel mantenible separa dominio, entrada HTTP, persistencia y presentación.',
                'content' => "En Laravel, las rutas deben delegar y los controladores coordinar. La validación vive en Form Requests, las reglas de negocio en servicios o acciones, y la persistencia en modelos, consultas y repositorios cuando la complejidad lo justifica.\n\nUsa migrations versionadas, policies para autorización, resources para respuestas API y jobs para tareas lentas. Mantén secretos en .env, configura producción con APP_DEBUG=false y prueba los flujos críticos con Feature Tests.\n\nLa estructura no es burocracia: reduce acoplamiento, hace explícitos los contratos y permite cambiar infraestructura sin reescribir la aplicación.",
            ],
            [
                'title' => 'Frameworks de PHP: cómo elegir una base técnica',
                'category' => 'PHP',
                'excerpt' => 'Laravel, Symfony y Slim resuelven problemas distintos; la decisión debe seguir el dominio y el ciclo de vida.',
                'content' => "Laravel ofrece productividad integrada: routing, ORM, colas, validación, mail y testing con una convención coherente. Symfony aporta componentes desacoplados, configurabilidad y una base sólida para plataformas empresariales de larga vida. Slim es apropiado cuando se necesita un microframework HTTP pequeño y una arquitectura definida por el equipo.\n\nLa comparación correcta incluye soporte PHP, seguridad, observabilidad, ecosistema, rendimiento bajo carga y disponibilidad de talento. Elegir por benchmarks aislados suele ser menos útil que evaluar el coste operativo y la claridad del código.",
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => str()->slug($post['title'])],
                [...$post, 'published' => true, 'published_at' => Carbon::now()->subDays(1)]
            );
        }
    }
}
