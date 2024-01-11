<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'lokasi', 'latitude', 'longitude', 'api_key', 'tegangan', 'status', 'updated_at'];

    protected $casts = [
        'id' => 'string',
    ];

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
