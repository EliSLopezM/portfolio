<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Orderable;
use App\Support\Media;
use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    use FlushesPortfolioCache, Orderable;

    protected $table = 'media';

    protected $fillable = ['scope', 'title', 'alt', 'path', 'visible', 'position'];

    protected $casts = ['visible' => 'boolean'];

    public function url(): ?string
    {
        return Media::url($this->path);
    }
}
