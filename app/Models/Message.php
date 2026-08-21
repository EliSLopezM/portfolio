<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'nombre', 'email', 'asunto', 'phone_country_iso',
        'phone_country_code', 'phone_number', 'mensaje', 'leido'
    ];
}