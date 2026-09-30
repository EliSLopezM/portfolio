<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StackCategory extends Model
{
    use FlushesPortfolioCache, Orderable;

    protected $fillable = ['slug', 'name', 'description', 'featured', 'visible', 'position'];

    protected $casts = ['featured' => 'boolean', 'visible' => 'boolean'];

    public function items(): HasMany
    {
        return $this->hasMany(StackItem::class)->ordered();
    }
}
