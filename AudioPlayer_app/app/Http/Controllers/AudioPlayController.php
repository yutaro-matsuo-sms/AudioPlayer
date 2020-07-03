<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AudioPlayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /*$user = Auth::user();
        $sort = $request->sort;
        $items = User::orderBy($sort, 'asc')
            ->simplePaginate(5);
        $param = ['items' => $items, 'sort' => $sort,
            'user' => $user];*/
    return view('audio_player/index', /*$param*/);
    }
}
