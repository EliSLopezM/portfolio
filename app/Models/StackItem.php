<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Orderable;
use App\Support\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StackItem extends Model
{
    use FlushesPortfolioCache, Orderable;

    public const LEVELS = ['dominio' => 'Dominio', 'estudio' => 'En estudio'];

    protected $fillable = ['stack_category_id', 'name', 'type', 'level', 'icon', 'visible', 'position'];

    protected $casts = ['visible' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(StackCategory::class, 'stack_category_id');
    }

    public function iconUrl(): ?string
    {
        return Media::url($this->icon);
    }
}
