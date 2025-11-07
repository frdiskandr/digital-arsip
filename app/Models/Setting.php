<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'slogan',
        'logo',
    ];

    // If you want to cast or add accessors, do it here.
}
