<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Orderable;
use App\Support\Media;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use FlushesPortfolioCache, Orderable;

    public const CATEGORIES = ['destacado' => 'Destacado', 'curso' => 'Curso'];

    protected $fillable = ['title', 'platform', 'year', 'pdf', 'preview', 'category', 'visible', 'position'];

    protected $casts = ['visible' => 'boolean'];

    public function pdfUrl(): ?string
    {
        return Media::url($this->pdf, 'images/certs');
    }

    public function previewUrl(): ?string
    {
        return Media::url($this->preview, 'images/certs');
    }
}
