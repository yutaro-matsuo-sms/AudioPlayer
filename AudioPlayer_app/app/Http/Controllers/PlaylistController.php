<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Playlist;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        return Playlist::orderBy('created_at', 'desc')->get();
    }

    public function insert(Request $request)
    {
        $playlist = new Playlist();
        $playlist->user_id = $request->user_id;
        $playlist->song_id = $request->song_id;
        $playlist->save();
        return $playlist;
    }

    public function update(Request $request, Playlist $playlist)
    {
        $playlist->user_id = $request->user_id;
        $playlist->song_id = $request->song_id;
        $playlist->save();
        return $playlist;
    }

    public function delete(Request $request, Playlist $playlist)
    {
        $result = 'ok';
        if (!$playlist->delete()) {
            $result = 'ng';
        }
        return compact('result');
    }
}
