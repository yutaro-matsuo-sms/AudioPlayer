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
};
