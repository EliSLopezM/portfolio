<?php

/*
| Tamaños de imagen del sitio — el ÚNICO lugar para cambiarlos.
|
| Cada imagen subida desde el dashboard se ajusta automáticamente a su preset y se guarda en WebP:
|   cover → recorta al centro hasta llenar exactamente w × h (para marcos de proporción fija)
|   fit   → reduce hasta caber en w × h sin recortar ni deformar (nunca agranda)
| Los valores son píxeles. Usa el doble del tamaño al que se ve en pantalla para pantallas retina.
*/
return [

    'quality' => 82,   // calidad WebP (1-100)
    'max_upload_kb' => 8192,

    'presets' => [
        'blog_cover' => ['label' => 'Portada del blog', 'w' => 1280, 'h' => 720, 'mode' => 'cover',
            'note' => 'Se ve 16:9 en listados y al compartir en redes.'],
        'blog_inline' => ['label' => 'Imagen dentro del blog', 'w' => 1200, 'h' => null, 'mode' => 'fit',
            'note' => 'Ancho máximo; el alto se calcula solo. En el editor eliges su tamaño de visualización.'],
        'project' => ['label' => 'Imagen de proyecto', 'w' => 1280, 'h' => 720, 'mode' => 'cover',
            'note' => 'Tarjeta 16:9.'],
        'certificate' => ['label' => 'Vista previa de certificado', 'w' => 800, 'h' => 600, 'mode' => 'cover',
            'note' => 'Tarjeta 4:3.'],
        'gallery' => ['label' => 'Imagen de galería', 'w' => 1200, 'h' => 900, 'mode' => 'cover',
            'note' => 'Marco 4:3 del carrusel.'],
        'icon' => ['label' => 'Icono de tecnología', 'w' => 128, 'h' => 128, 'mode' => 'fit',
            'note' => 'Se muestra a 36 px; conserva la transparencia.'],
    ],
];
