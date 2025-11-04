<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kategori extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['nama', 'deskripsi'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('kategori')
            ->logOnly(['nama', 'deskripsi'])
            ->logOnlyDirty();
    }

    public function arsip()
    {
        return $this->hasMany(Arsip::class);
    }

    public function activities()
    {
        return $this->morphMany(\Spatie\Activitylog\Models\Activity::class, 'subject');
    }
}
