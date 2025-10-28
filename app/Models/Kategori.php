<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'deskripsi'];

    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }
}
