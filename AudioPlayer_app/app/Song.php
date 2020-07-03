<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'name',
        'artist',
        'song',
        'image',
        'is_favorite',    
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'Playlist', 'song_id', 'user_id');
    }
};
