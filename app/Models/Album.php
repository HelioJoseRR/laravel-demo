<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'artist', 'release_date'];

    protected $casts = [
        'release_date' => 'datetime',
    ];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
