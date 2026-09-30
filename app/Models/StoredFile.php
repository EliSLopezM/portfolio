<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoredFile extends Model
{
    protected $fillable = ['name', 'folder', 'mime', 'size', 'width', 'height', 'data'];

    protected $hidden = ['data'];

    public function binary(): string
    {
        return base64_decode($this->data, true) ?: '';
    }
}
