<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipVersion extends Model
{
    use HasFactory;

    /**
     * We don't use standard timestamps, only created_at which is set manually.
     */
    public $timestamps = false;

    protected $fillable = [
        'arsip_id',
        'version',
        'judul',
        'deskripsi',
        'file_path',
        'original_file_name',
        'user_id',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the main archive record that this version belongs to.
     */
    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }

    /**
     * Get the user who created this version.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}