<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {username=eslopezm : Usuario de acceso} {--name=Eli Santiago López Mahecha} {--email=eslopez.dev@gmail.com}';

    protected $description = 'Crea o actualiza el administrador del dashboard. La contraseña se lee de ADMIN_PASSWORD o se pide por consola.';

    public function handle(): int
    {
        $password = ($_SERVER['ADMIN_PASSWORD'] ?? $_ENV['ADMIN_PASSWORD'] ?? getenv('ADMIN_PASSWORD')) ?: $this->secret('Contraseña');

        $validator = Validator::make(
            ['username' => $this->argument('username'), 'password' => $password],
            ['username' => ['required', 'regex:/^[A-Za-z0-9._-]{3,50}$/'], 'password' => ['required', 'string', 'min:12', 'max:200']],
        );

        if ($validator->fails()) {
            $this->error(implode(' ', $validator->errors()->all()));

            return self::FAILURE;
        }

        $user = User::firstOrNew(['username' => $this->argument('username')]);
        $user->forceFill([
            'name' => $this->option('name'),
            'email' => $user->email ?: $this->option('email'),
            'password' => $password, // el cast "hashed" la guarda con bcrypt
            'is_admin' => true,
        ])->save();

        $this->info("Administrador «{$user->username}» listo.");

        return self::SUCCESS;
    }
}
