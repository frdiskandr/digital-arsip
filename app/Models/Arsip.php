<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Arsip extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'kategori_id',
        'subjek_id',
        'user_id',
        'tanggal_arsip',
        'original_file_name',
        'version',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($arsip) {
            // Only create a version if the record already exists (it's an update)
            // and if something has actually changed.
            if ($arsip->exists && $arsip->isDirty()) {
                $originalData = $arsip->getOriginal();

                // Create a snapshot of the current version before it's updated
                $arsip->versions()->create([
                    'version'            => $originalData['version'],
                    'judul'              => $originalData['judul'],
                    'deskripsi'          => $originalData['deskripsi'],
                    'file_path'          => $originalData['file_path'],
                    'original_file_name' => $originalData['original_file_name'],
                    'user_id'            => auth()->id(), // The user making the change
                    'created_at'         => $originalData['updated_at'], // The date of the old version
                ]);

                // Increment the version for the new update
                $arsip->version++;
            }
        });
    }

    /**
     * Get all historical versions for the archive.
     */
    public function versions()
    {
        return $this->hasMany(ArsipVersion::class)->orderBy('version', 'desc');
    }

    /**
     * Configure activity logging options for Arsip model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('arsip')
            ->logOnly(['judul', 'deskripsi', 'kategori_id'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activities()
    {
        return $this->morphMany(\Spatie\Activitylog\Models\Activity::class, 'subject');
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
            if (preg_match('/\\d{4}-\\d{2}-\\d{2}-\\d{6}_[a-f0-9]{32}_(.+)$/', $fileName, $matches)) {
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
            if (preg_match('/\\d{4}-\\d{2}-\\d{2}-\\d{6}_[a-f0-9]{32}_(.+)$/', $fileName, $matches)) {
                $this->attributes['original_file_name'] = $matches[1];
            } else {
                $this->attributes['original_file_name'] = $fileName;
            }
        }
    }

    /**
     * Casts
     */
    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
