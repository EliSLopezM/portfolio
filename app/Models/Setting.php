<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use FlushesPortfolioCache;

    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    protected $casts = ['value' => 'array'];
}
