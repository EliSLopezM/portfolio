<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Genera metadatos SEO a partir del contenido del blog.
 * Los campos manuales del editor siempre tienen prioridad sobre lo generado.
 */
class SeoGenerator
{
    private const STOPWORDS = [
        'para', 'como', 'pero', 'porque', 'sobre', 'entre', 'desde', 'hasta', 'donde', 'cuando', 'este', 'esta',
        'estos', 'estas', 'esto', 'ellos', 'cada', 'todo', 'todos', 'todas', 'puede', 'pueden', 'hacer', 'tiene',
        'tienen', 'desde', 'cuyo', 'unos', 'unas', 'otra', 'otro', 'otros', 'mismo', 'misma', 'menos', 'mucho',
        'muchos', 'tambien', 'además', 'ademas', 'según', 'segun', 'debe', 'deben', 'forma', 'parte', 'siempre',
        'suele', 'sino', 'antes', 'después', 'despues', 'entonces', 'ahora', 'aquí', 'allí', 'with', 'that', 'this',
        'from', 'have', 'your', 'will', 'into', 'more', 'than', 'their', 'about',
    ];

    public static function plainText(?string $html): string
    {
        $text = html_entity_decode(strip_tags(str_replace(['</p>', '</li>', '<br>', '<br/>', '</h2>', '</h3>'], ' ', (string) $html)), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text));
    }

    public static function title(string $title, ?string $manual = null): string
    {
        return filled($manual) ? $manual : Str::limit($title, 60, '…');
    }

    public static function description(string $excerpt, string $content, ?string $manual = null): string
    {
        if (filled($manual)) {
            return $manual;
        }

        $source = self::plainText($excerpt) ?: self::plainText($content);

        return Str::limit($source, 158, '…');
    }

    public static function keywords(string $title, string $category, string $excerpt, string $content, ?string $manual = null, int $max = 8): string
    {
        if (filled($manual)) {
            return $manual;
        }

        $text = Str::lower($title.' '.$title.' '.$excerpt.' '.self::plainText($content));
        $words = preg_split('/[^\p{L}\p{N}+#.]+/u', $text, -1, PREG_SPLIT_NO_EMPTY);

        $counts = [];
        foreach ($words as $word) {
            $word = trim($word, '.');
            if (mb_strlen($word) < 5 || in_array($word, self::STOPWORDS, true) || is_numeric($word)) {
                continue;
            }
            $counts[$word] = ($counts[$word] ?? 0) + 1;
        }

        arsort($counts);
        $keywords = array_slice(array_keys($counts), 0, $max);

        $categoryLabel = Str::of($category)->replace('dcc-', 'defensa civil ')->lower()->toString();
        array_unshift($keywords, $categoryLabel);

        return implode(', ', array_unique($keywords));
    }

    public static function readingMinutes(string $content): int
    {
        return max(1, (int) ceil(str_word_count(self::plainText($content)) / 200));
    }
}
