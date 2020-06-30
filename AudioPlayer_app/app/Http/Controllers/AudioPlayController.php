<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AudioPlayer;

class AudioPlayController extends Controller
{
    public function index()
    {
        return view('audio_player/index');
    }
}
