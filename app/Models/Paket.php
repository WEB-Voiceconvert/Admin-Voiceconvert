<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_paket', 'nominal', 'masa_berlaku'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
