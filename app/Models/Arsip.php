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
        'tanggal_arsip',
        'original_file_name',
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
        // Prefer stored original_file_name column when available
        if (!empty($this->attributes['original_file_name'])) {
            return $this->attributes['original_file_name'];
        }

        if ($this->file_path) {
            $fileName = basename($this->file_path);
            // Remove timestamp and hash from filename if present
            if (preg_match('/\d{4}-\d{2}-\d{2}-\d{6}_[a-f0-9]{32}_(.+)$/', $fileName, $matches)) {
                return $matches[1];
            }
            return $fileName;
        }

        return null;
    }

    /**
     * When saving file_path, also set original_file_name if not provided.
     */
    public function setFilePathAttribute($value)
    {
        $this->attributes['file_path'] = $value;

        // If original_file_name column exists and not set, try to extract original name
        if (empty($this->attributes['original_file_name']) && $value) {
            $fileName = basename($value);
            if (preg_match('/\d{4}-\d{2}-\d{2}-\d{6}_[a-f0-9]{32}_(.+)$/', $fileName, $matches)) {
                $this->attributes['original_file_name'] = $matches[1];
            } else {
                $this->attributes['original_file_name'] = $fileName;
            }
        }
    }
}
