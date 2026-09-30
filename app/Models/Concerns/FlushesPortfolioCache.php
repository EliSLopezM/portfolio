<?php

namespace App\Models\Concerns;

use App\Services\PortfolioContent;

trait FlushesPortfolioCache
{
    public static function bootFlushesPortfolioCache(): void
    {
        $flush = fn () => PortfolioContent::flush();
        static::saved($flush);
        static::deleted($flush);
    }
}
