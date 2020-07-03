@extends('layouts.app')
@section('title', 'audio_play')

@if(Auth::check())
@section('content')
<div id="app">
    <player></player>
</div>
@endsection
@else
<p>※ログインしてください。</p>
<p><a href="/login">ログイン</a></p>
<p><a href="/register">登録</a></p>
@endif