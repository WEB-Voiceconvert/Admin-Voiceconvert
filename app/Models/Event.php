<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['id_category', 'nama_event', 'lokasi', 'tgl_event', 'deskripsi', 'id_alat', 'latitude', 'longitude'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'id_category');
    }

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function voices(): HasMany
    {
        return $this->hasMany(Voice::class, 'id_event');
    }
}
