<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'gambar', 'id_alat', 'latitude', 'longitude'];

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    public function voices(): HasMany
    {
        return $this->hasMany(Voice::class, 'id_berita');
    }
}
