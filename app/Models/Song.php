<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'artist', 'album_id', 'genre', 'duration'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
