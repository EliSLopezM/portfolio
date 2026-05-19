# 🗂️ Portfolio — Eli Santiago López
**eslopez.dev@gmail.com · github.com/EliSLopezM**

Portafolio personal construido con **Laravel 10** + Blade, CSS vanilla y JS vanilla.
Sin dependencias de frontend pesadas — todo en menos de 100 KB.

---

## 📁 Estructura del proyecto

```
portfolio-eli/
├── app/Http/Controllers/
│   └── PortfolioController.php     # Único controlador
├── config/
│   └── portfolio.php               # ← EDITA AQUÍ tus datos
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php           # Layout principal (head, nav, footer)
│   ├── partials/
│   │   ├── nav.blade.php           # Navegación
│   │   └── footer.blade.php        # Footer
│   ├── sections/
│   │   ├── hero.blade.php          # Sección principal
│   │   ├── sobre.blade.php         # Sobre mí
│   │   ├── stack.blade.php         # Stack tecnológico
│   │   ├── proyectos.blade.php     # Proyectos con capturas
│   │   ├── experiencia.blade.php   # Timeline laboral
│   │   └── contacto.blade.php      # Formulario de contacto
│   └── portfolio/
│       └── index.blade.php         # Vista principal (orquesta sections)
├── routes/
│   └── web.php                     # GET / y POST /contacto
└── public/
    ├── css/app.css                  # Estilos completos
    ├── js/app.js                    # Nav scroll, fade-in, mobile
    └── images/                      # ← Pon aquí tus capturas
        ├── timi.jpg
        ├── deuna.jpg
        ├── katapulta.jpg
        └── ecologicads.jpg
```

---

## 🚀 Instalación local

```bash
# 1. Clona o copia el proyecto en tu Laravel existente
git clone https://github.com/EliSLopezM/portfolio.git
cd portfolio

# 2. Instala dependencias PHP
composer install

# 3. Copia el archivo de entorno
cp .env.example .env
php artisan key:generate

# 4. Configura tu .env (no necesita base de datos)
# Solo necesitas configurar mail si quieres el formulario de contacto:
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.gmail.com
# MAIL_PORT=587
# MAIL_USERNAME=eslopez.dev@gmail.com
# MAIL_PASSWORD=tu_app_password

# 5. Inicia el servidor
php artisan serve
# → http://localhost:8000
```

---

## 📸 Agregar capturas de proyectos

Coloca las imágenes en `public/images/` con estos nombres exactos:
- `timi.jpg`
- `deuna.jpg`
- `katapulta.jpg`
- `ecologicads.jpg`

**Tamaño recomendado:** 1280×720 px, formato JPG o PNG.
Si no existe la imagen, el portafolio muestra un placeholder automáticamente.

---

## ✏️ Personalizar contenido

Todo el contenido está centralizado en **`config/portfolio.php`** — edita ese
archivo para cambiar nombre, proyectos, stack, experiencia, etc.

---

## 🌐 Deploy en Railway (gratis, PHP/Laravel soportado)

> Railway es la mejor opción gratis para Laravel. Vercel no ejecuta PHP.

1. Sube tu repo a GitHub
2. Ve a [railway.app](https://railway.app) → New Project → Deploy from GitHub
3. Selecciona tu repo
4. Railway detecta Laravel automáticamente
5. En Variables, agrega:
   - `APP_KEY` (copia de tu .env local)
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://tu-app.railway.app`
6. Tu URL queda lista: `https://portfolio-eli.railway.app`

### Alternativa: Render.com (también gratis)
1. New → Web Service → conecta tu repo
2. Runtime: PHP / build command: `composer install --no-dev`
3. Start command: `php artisan serve --host=0.0.0.0 --port=$PORT`

---

## 📦 Requisitos

- PHP 8.1+
- Composer
- Laravel 10.x
- No necesita base de datos

---

## 📬 Formulario de contacto

El formulario usa `POST /contacto` con validación Laravel.
Para activar el envío real de emails:

1. Descomenta la línea `Mail::to(...)` en `PortfolioController.php`
2. Crea `app/Mail/ContactMail.php` con `php artisan make:mail ContactMail`
3. Configura las variables MAIL_* en `.env`

O usa **Formspree** (gratis, sin backend) cambiando el `action` del form en
`sections/contacto.blade.php` a `https://formspree.io/f/YOUR_ID`.

---

**Eli Santiago López · eslopez.dev@gmail.com**
