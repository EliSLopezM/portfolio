<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje de contacto</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f4f0; padding:24px; color:#1a1c1e;">
    <table role="presentation" width="100%" style="max-width:560px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e4e2dc;">
        <tr>
            <td style="background:#1a1c1e; padding:20px 28px;">
                <span style="color:#f0c040; font-size:12px; letter-spacing:0.08em; text-transform:uppercase;">Portafolio</span>
                <h1 style="color:#ffffff; font-size:18px; margin:6px 0 0;">Nuevo mensaje de contacto</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:28px;">
                <p style="margin:0 0 14px;"><strong>Nombre:</strong> {{ $data['nombre'] ?? '' }}</p>
                <p style="margin:0 0 14px;"><strong>Email:</strong> {{ $data['email'] ?? '' }}</p>
                <p style="margin:0 0 14px;"><strong>Asunto:</strong> {{ $data['asunto'] ?? 'Sin asunto' }}</p>
                <p style="margin:0 0 6px;"><strong>Mensaje:</strong></p>
                <p style="margin:0; white-space:pre-wrap; line-height:1.6;">{{ $data['mensaje'] ?? '' }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
