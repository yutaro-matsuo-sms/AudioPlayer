<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AudioPlayController extends Controller
{
    public function index()
    {
        return view('audio_player/index');
    }
}
