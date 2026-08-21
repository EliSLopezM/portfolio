# 🗂️ Portfolio — Eli Santiago López
**eslopez.dev@gmail.com · github.com/EliSLopezM**

Portafolio profesional de **Eli Santiago López Mahecha**, Ingeniero de Sistemas y Full Stack Developer en Bogotá, Colombia. Construido con Laravel 12, Blade, CSS vanilla y JavaScript vanilla para una experiencia rápida, accesible y responsive.

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
git clone https://github.com/EliSLopezM/portfolio.git
cd portfolio

# 2. Instala dependencias PHP
composer install

# 3. Copia el archivo de entorno
cp .env.example .env
php artisan key:generate

# 4. Instala y compila los assets
npm install
npm run build

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

## Configuracion del formulario

Copia `.env.example` a `.env` y configura SMTP y reCAPTCHA v3:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=eslopez.dev@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=eslopez.dev@gmail.com
MAIL_FROM_NAME="Eli Santiago Lopez"
RECAPTCHA_SITE_KEY=tu_clave_publica_v3
RECAPTCHA_SECRET_KEY=tu_clave_privada_v3
WHATSAPP_ACCESS_TOKEN=token_privado_de_meta
WHATSAPP_PHONE_NUMBER_ID=id_del_numero_de_meta
WHATSAPP_API_VERSION=v23.0
WHATSAPP_TEMPLATE=portfolio_new_contact
WHATSAPP_TEMPLATE_LANGUAGE=es_CO
WHATSAPP_ALERT_TO=573001234567
```

Los mensajes se guardan en la base de datos y se notifican a `eslopez.dev@gmail.com`. reCAPTCHA v3 valida la accion `contact` con puntuacion minima de `0.5`; el endpoint admite seis envios por minuto por cliente.

El aviso de WhatsApp usa la **WhatsApp Cloud API** y una plantilla transaccional aprobada por Meta llamada `portfolio_new_contact`, con tres variables en el cuerpo: nombre, email y teléfono. Crea la plantilla en Meta Business con un texto como `Nuevo mensaje en tu correo. Posible cliente: {{1}} | {{2}} | {{3}}. Revisa tu bandeja de entrada.` y coloca las credenciales directamente en `.env`. Nunca las subas a Git.

## SEO y responsive

El layout incluye canonical, Open Graph, Twitter Cards, datos estructurados `Person`, sitemap en `/sitemap.xml` y `robots.txt`. La navegacion, formularios, tarjetas y botones se adaptan a pantallas pequenas.

## Deploy en Railway (PHP/Laravel soportado)

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

- PHP 8.2+
- Composer 2+
- Node.js 20+ y npm
- Laravel 12.x
- MySQL o SQLite

---

## Enlaces oficiales

- GitHub: https://github.com/EliSLopezM
- LinkedIn: https://www.linkedin.com/in/eli-santiago-lopez-mahecha-56a9861b9/
- Email: eslopez.dev@gmail.com

## Autoría

Copyright 2026 Eli Santiago López Mahecha. Todos los derechos reservados sobre el contenido, identidad y material original de este portafolio.

**Eli Santiago López · eslopez.dev@gmail.com**
