<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;

class SongController extends Controller
{
    public function index(Request $request)
    {
        return \Auth::user()->songs()->get();
    }

    public function insert(Request $request)
    {
        $song = new Song();
        $song->name = $request->name;
        $song->artist = $request->artist;
        $song->song = $request->song;
        $song->image = $request->image;
        $song->is_Favorite = $request->is_favorite;
        $song->save();
        return $song;
    }

    public function update(Request $request, Song $song)
    {
        $song->name = $request->name;
        $song->artist = $request->artist;
        $song->song = $request->song;
        $song->image = $request->image;
        $song->is_favorite = $request->is_favorite;
        $song->save();
        return $song;
    }

    public function delete(Request $request, Song $song)
    {
        $result = 'ok';
        if (!$song->delete()) {
            $result = 'ng';
        }
        return compact('result');
    }
}
