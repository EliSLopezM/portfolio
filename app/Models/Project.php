<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Orderable;
use App\Support\Media;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use FlushesPortfolioCache, Orderable;

    protected $fillable = ['title', 'company', 'url', 'github', 'image', 'tags', 'description', 'links', 'visible', 'position'];

    protected $casts = ['tags' => 'array', 'links' => 'array', 'visible' => 'boolean'];

    public function imageUrl(): ?string
    {
        return Media::url($this->image, 'images');
    }
}
