<?php

return [

    'author' => env('ADMIN_AUTHOR', 'Eli Santiago López Mahecha'),

    // Inactividad máxima del panel (minutos) antes de cerrar la sesión.
    'idle_minutes' => (int) env('ADMIN_IDLE_MINUTES', 30),

    // Intentos de login fallidos antes del bloqueo temporal.
    'max_attempts' => (int) env('ADMIN_MAX_ATTEMPTS', 5),
    'lockout_minutes' => (int) env('ADMIN_LOCKOUT_MINUTES', 15),

    'message_statuses' => [
        'leido' => 'Leído',
        'contactado' => 'Contactado',
        'negociacion' => 'En negociación',
        'contrato' => 'Contrato',
        'spam' => 'Spam',
    ],

    'event_types' => [
        'especial' => 'Día especial',
        'reunion' => 'Reunión',
        'actividad' => 'Actividad',
    ],

    'post_categories' => [
        'dcc' => ['dcc-evento' => 'Evento', 'dcc-informativo' => 'Informativo'],
        'develop' => ['Laravel' => 'Laravel', 'PHP' => 'PHP', 'IA aplicada' => 'IA aplicada', 'Seguridad' => 'Seguridad', 'General' => 'General'],
    ],

    // Disco donde se guardan las subidas (carpeta pública). Usa "s3" si el hosting tiene disco efímero.
    'uploads_disk' => env('UPLOADS_DISK', 'uploads'),
];
