<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'nombre', 'email', 'asunto', 'phone_country_iso',
        'phone_country_code', 'phone_number', 'mensaje',
        'statuses', 'ip', 'recaptcha_score',
    ];

    protected $casts = ['statuses' => 'array'];

    public function hasStatus(string $status): bool
    {
        return in_array($status, $this->statuses ?? [], true);
    }

    public function isUnread(): bool
    {
        return ! $this->hasStatus('leido');
    }

    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->whereJsonContains('statuses', $status);
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where(fn ($q) => $q->whereNull('statuses')->orWhereJsonDoesntContain('statuses', 'leido'));
    }
}
