<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'kategori_id',
        'user_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return url('storage/' . $this->file_path);
        }
        return null;
    }

    public function getOriginalFileNameAttribute()
    {
        if ($this->file_path) {
            $fileName = basename($this->file_path);
            // Remove timestamp and hash from filename
            preg_match('/\d{4}-\d{2}-\d{2}-\d{6}_[a-f0-9]{32}_(.+)$/', $fileName, $matches);
            return $matches[1] ?? $fileName;
        }
        return null;
    }
}
