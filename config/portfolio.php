<?php

return [

    'name'     => 'Eli Santiago López Mahecha',
    'role'     => 'Full Stack Developer',
    'tagline'  => 'Ingeniero de Sistemas con +3 años construyendo plataformas robustas con PHP/Laravel, recuperando proyectos abandonados y llevándolos a producción.',
    'email'    => 'eslopez.dev@gmail.com',
    'phone'    => '+57 301 425 5344',
    'location' => 'Bogotá, Colombia',
    'github'   => 'https://github.com/EliSLopezM',
    'linkedin' => 'https://linkedin.com/in/eli-santiago',
    'cv_path'  => '/cv/CV_EliSantiago_Lopez.pdf',
    'available'=> true,

    'stats' => [
        ['value' => '3+',  'label' => 'Años de experiencia'],
        ['value' => '6',   'label' => 'Proyectos en producción'],
        ['value' => '2',   'label' => 'Apps móviles publicadas'],
        ['value' => '100%','label' => 'Proyectos entregados'],
    ],

    'about' => [
        'paragraph1' => 'Soy Eli Santiago López, Ingeniero de Sistemas graduado de la Fundación Universitaria Los Libertadores (2024). Más de 3 años desarrollando software full stack en entornos reales y de producción.',
        'paragraph2' => 'Me especializo en <strong>PHP/Laravel</strong> para backend, <strong>Angular</strong> para frontend y arquitectura de servidores Linux con Docker. Mi diferencial: restaurar proyectos inconclusos o abandonados y llevarlos a producción funcional.',
        'paragraph3' => 'Actualmente soy el encargado del área tecnológica en <strong>Steps Consulting Corp</strong>, donde coordino requerimientos, defino arquitecturas y entrego productos a clientes directos.',
    ],

    'stack' => [
        ['abbr' => 'PHP',  'name' => 'PHP 8.2',        'type' => 'Lenguaje principal'],
        ['abbr' => 'LRV',  'name' => 'Laravel',         'type' => 'Framework backend'],
        ['abbr' => 'PY',   'name' => 'Python',           'type' => 'Scripting & automatización'],
        ['abbr' => 'NG',   'name' => 'Angular',          'type' => 'Framework frontend'],
        ['abbr' => 'NODE', 'name' => 'Node.js',          'type' => 'Runtime JS backend'],
        ['abbr' => 'GO',   'name' => 'Go',               'type' => 'Microservicios'],
        ['abbr' => 'FB',   'name' => 'Firebase',         'type' => 'Auth & tiempo real'],
        ['abbr' => 'MY',   'name' => 'MySQL / PgSQL',    'type' => 'Bases de datos'],
        ['abbr' => 'DKR',  'name' => 'Docker',           'type' => 'Contenedores & deploy'],
        ['abbr' => 'MOB',  'name' => 'Android / iOS',    'type' => 'Apps móviles'],
        ['abbr' => 'LNX',  'name' => 'Servidores Linux', 'type' => 'Nginx, infraestructura'],
        ['abbr' => 'API',  'name' => 'REST APIs',        'type' => 'Diseño & integración'],
    ],

    'projects' => [
        [
            'title'   => 'Timi — Plataforma Web & Apps Móviles',
            'company' => 'Steps Consulting Corp',
            'url'     => 'https://timiweb.com',
            'github'  => null,
            'image'   => 'timi.jpg',
            'tags'    => ['Laravel', 'Angular', 'Firebase', 'MySQL', 'Docker', 'iOS', 'Android'],
            'desc'    => 'Plataforma web construida desde cero con Laravel + panel de administración completo. Recuperé las apps Timi User y Timi Driver (iOS/Android) de un estado de abandono, actualizadas y publicadas nuevamente en Play Store y App Store. Integración con Firebase para autenticación en tiempo real.',
            'links'   => [
                ['label' => 'timiweb.com', 'url' => 'https://timiweb.com', 'featured' => true],
                ['label' => 'Play Store', 'url' => '#', 'featured' => false],
            ],
        ],
        [
            'title'   => 'DeUna Marketing — Reconstrucción Total',
            'company' => 'Steps Consulting Corp',
            'url'     => 'https://deunamarketing.com',
            'github'  => null,
            'image'   => 'deuna.jpg',
            'tags'    => ['Laravel', 'MySQL', 'Nginx', 'Linux', 'SEO'],
            'desc'    => 'Plataforma de marketing digital reconstruida desde los cimientos a partir de un proyecto obsoleto. Rediseño completo de arquitectura, base de datos y frontend. Módulos de gestión de contenido, formularios y optimización SEO técnica. Servidor Linux con Nginx configurado para producción.',
            'links'   => [
                ['label' => 'deunamarketing.com', 'url' => 'https://deunamarketing.com', 'featured' => true],
            ],
        ],
        [
            'title'   => 'Katapulta — Espacio Virtual UCSM',
            'company' => 'Universidad San Martín',
            'url'     => 'https://katapulta.sanmartin.edu.co',
            'github'  => null,
            'image'   => 'katapulta.jpg',
            'tags'    => ['Laravel', 'MySQL', 'PHP', 'Roles & Auth'],
            'desc'    => 'Espacio virtual educativo desarrollado desde cero para la Universidad San Martín. Gestión de usuarios, cursos y contenido académico. Autenticación segura con roles diferenciados: estudiante, docente y administrador, implementados con Laravel y MySQL.',
            'links'   => [
                ['label' => 'katapulta.sanmartin.edu.co', 'url' => 'https://katapulta.sanmartin.edu.co', 'featured' => true],
            ],
        ],
        [
            'title'   => 'EcologicAds — Actualización & Optimización',
            'company' => 'Proyecto externo',
            'url'     => 'https://ecologicads.com',
            'github'  => null,
            'image'   => 'ecologicads.jpg',
            'tags'    => ['PHP', 'MySQL', 'Linux', 'Cache', 'SQL Tuning'],
            'desc'    => 'Plataforma de publicidad ecológica actualizada y optimizada. Corrección de deuda técnica acumulada y modernización de arquitectura de base de datos. Mejoras de rendimiento mediante optimización de consultas SQL, implementación de caché y ajustes en servidor Linux.',
            'links'   => [
                ['label' => 'ecologicads.com', 'url' => 'https://ecologicads.com', 'featured' => true],
            ],
        ],
    ],

    'experience' => [
        [
            'period'  => '2022 — Presente',
            'role'    => 'Programador Full Stack & Encargado de Tecnología',
            'company' => 'Steps Consulting Corp · Remoto, Colombia',
            'current' => true,
            'items'   => [
                'Desarrollo de plataformas web completas desde cero con PHP/Laravel.',
                'Reactivación de apps móviles Timi User y Timi Driver (iOS & Android).',
                'Diseño de arquitectura de servidores Linux, MySQL/PostgreSQL y pipelines con Docker.',
                'Liderazgo técnico: coordinación de requerimientos y entregas con clientes directos.',
            ],
            'tags' => ['Laravel', 'Angular', 'Node.js', 'MySQL', 'Docker', 'Firebase', 'Linux'],
        ],
        [
            'period'  => '2024',
            'role'    => 'Ingeniero de Sistemas — Graduado',
            'company' => 'Fundación Universitaria Los Libertadores · Bogotá',
            'current' => false,
            'items'   => [
                'Grado en Ingeniería de Sistemas.',
                'Certificaciones y estudios complementarios verificables en LinkedIn.',
            ],
            'tags' => ['Educación'],
        ],
    ],

    'languages' => [
        ['name' => 'Español', 'level' => 'Nativo',            'pct' => 100],
        ['name' => 'Inglés',  'level' => 'Básico-Intermedio', 'pct' => 45],
    ],

];
