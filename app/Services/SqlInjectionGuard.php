<?php

namespace App\Services;

/**
 * Detección de cargas SQL típicas en texto enviado por el usuario.
 *
 * Es una segunda barrera: la protección real son las consultas parametrizadas de Eloquent.
 * Los patrones exigen sintaxis de ataque (no solo palabras sueltas) para no bloquear texto normal.
 */
class SqlInjectionGuard
{
    private const PATTERNS = [
        '/\bunion\b\s+(all\s+)?select\b/i',
        '/[\'"`)]\s*(or|and|xor)\s+[\'"`(]?\w+[\'"`)]?\s*(=|like|<|>)\s*[\'"`(]?\w+/i',
        '/\b(or|and)\s+\d+\s*=\s*\d+/i',
        '/;\s*(drop|delete|insert|update|alter|truncate|create|exec|select|shutdown)\b/i',
        '/[\'"`]\s*(--|#|\/\*)/',
        '/\b(sleep|benchmark|pg_sleep|load_file|char|concat|extractvalue|updatexml)\s*\(\s*[\d\'"@]/i',
        '/\bwaitfor\s+delay\b/i',
        '/\b(information_schema|xp_cmdshell|sqlite_master|pg_catalog|mysql\.user)\b/i',
        '/\binto\s+(out|dump)file\b/i',
        '/\bselect\s+(\*|@@\w+|[\w.`]+\s*\(|[\w.`]+\s*,\s*[\w.`]+\s+from\b)/i',
        '/\b(drop|truncate)\s+(table|database|schema)\b/i',
        '/\bdelete\s+from\s+[\w.`"]+/i',
        '/\binsert\s+into\s+[\w.`"]+/i',
        '/\bupdate\s+[\w.`"]+\s+set\s+[\w.`"]+\s*=/i',
        '/\x00/',
    ];

    public static function detect(string $value): bool
    {
        foreach (self::PATTERNS as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }

        return false;
    }

    /** Recorre arrays anidados buscando el primer valor sospechoso y devuelve su clave. */
    public static function findInArray(array $data, array $skipKeys = [], string $prefix = ''): ?string
    {
        foreach ($data as $key => $value) {
            if (in_array((string) $key, $skipKeys, true)) {
                continue;
            }

            $path = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                if ($found = self::findInArray($value, $skipKeys, $path)) {
                    return $found;
                }
            } elseif (is_string($value) && self::detect($value)) {
                return $path;
            }
        }

        return null;
    }
}
