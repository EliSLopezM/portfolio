<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CalendarEvent extends Model
{
    protected $fillable = ['title', 'description', 'type', 'starts_on', 'ends_on', 'starts_at', 'location', 'visible'];

    protected $casts = ['starts_on' => 'date', 'ends_on' => 'date', 'visible' => 'boolean'];

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', true);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate(DB::raw('COALESCE(ends_on, starts_on)'), '>=', today())->orderBy('starts_on');
    }
}
