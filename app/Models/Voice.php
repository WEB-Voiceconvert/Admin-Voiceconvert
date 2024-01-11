<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voice extends Model
{
    use HasFactory;

    protected $fillable = ['id_event', 'id_berita', 'filename', 'title'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id_event');
    }

    public function berita(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id_berita');
    }
}
