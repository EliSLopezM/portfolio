# Despliegue a producción (Hostinger)

Rama a desplegar: `main`. Las claves reales viven solo en el `.env` del servidor; nunca en Git, chats ni correos.

## 1. Antes de empezar
```bash
cd ~/domains/elislopezm.com/public_html   # ajustar a la ruta real del proyecto
php -v                                      # debe ser 8.3+ (recomendado 8.4)
php -m | grep -Ei "^(gd|mbstring|xml|curl|zip|pdo_mysql)$"   # deben salir las 6
cp .env ~/env-backup-$(date +%F).env        # respaldo del .env
mysqldump -u USUARIO -p BASE > ~/db-backup-$(date +%F).sql   # respaldo de la base
```

## 2. Código y dependencias
```bash
git fetch origin && git checkout main && git pull origin main
git log --oneline -1                        # debe mostrar a8c2e06 o posterior
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache && php artisan route:cache && php artisan view:cache
chmod -R ug+rwX storage bootstrap/cache
```

## 3. reCAPTCHA v3 (claves en el `.env` del servidor)
Editar con `nano .env` y dejar solo estas dos líneas (sin comillas ni espacios):
```
RECAPTCHA_SITE_KEY=<clave de sitio>
RECAPTCHA_SECRET_KEY=<clave secreta>
RECAPTCHA_BYPASS_LOCAL=false
```
Luego `php artisan config:cache` para que las tome.

En https://www.google.com/recaptcha/admin la clave debe ser de tipo **v3** y tener los dominios `elislopezm.com` y `www.elislopezm.com`.

Verificar que la clave secreta es válida (no imprime la clave):
```bash
SECRET=$(grep '^RECAPTCHA_SECRET_KEY=' .env | cut -d= -f2-)
curl -s -d "secret=$SECRET" -d "response=prueba" https://www.google.com/recaptcha/api/siteverify
```
- `"error-codes": ["invalid-input-response"]` → la clave secreta es correcta.
- `"invalid-input-secret"` → la clave secreta está mal escrita o no corresponde.

Verificar que la de sitio llega al HTML:
```bash
curl -s https://www.elislopezm.com/contacto | grep -o "recaptcha/api.js?render=[A-Za-z0-9_-]*"
```
Debe mostrar la clave de sitio exacta. Si no sale nada, el `.env` no se cargó (repetir `config:cache`).

## 4. Revisión del `.env`
```bash
grep -E "^(APP_ENV|APP_DEBUG|SESSION_SECURE_COOKIE|RECAPTCHA_BYPASS_LOCAL)=" .env
```
Esperado: `APP_ENV=production`, `APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`, `RECAPTCHA_BYPASS_LOCAL=false`. Revisar también `MAIL_*` (contraseña de aplicación de Gmail) y `WHATSAPP_*`.

## 5. PHP en hPanel (Avanzado → Configuración de PHP)
- `expose_php` = Off
- `session.upload_progress.enabled` = Off (mitigación del tercer CVE de PHP; revisar php.net por el parche)
- Versión PHP 8.4 si el plan lo permite, y volver a ejecutar `composer install` y `config:cache`.

## 6. Verificación final
```bash
curl -sI https://www.elislopezm.com | grep -iE "^(HTTP|x-powered-by|content-security-policy)"
curl -s -o /dev/null -w "%{http_code}\n" https://www.elislopezm.com/images/EliWeb.webp   # 200
curl -s https://www.elislopezm.com/contacto | grep -o "linkedin.com/in/[a-z0-9-]*" | sort -u
tail -n 30 storage/logs/laravel.log
```
En el navegador (Ctrl+F5, consola F12 sin errores en rojo): inicio, carrusel y PDF de certificados, `/contacto` (enviar un mensaje de prueba), `/dcc`, `/login` (iniciar sesión).

## 7. Si algo falla
```bash
git checkout <commit-anterior-estable> && composer install --no-dev --optimize-autoloader
php artisan optimize:clear && php artisan config:cache
```
y restaurar el respaldo de la base si hizo falta. No volver a commits anteriores a `a8c2e06`.
