@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/work.css') }}" />
@endsection

@section('link')
<form action="/" class="home__button">
    @csrf
    <input type="submit" class="header__link" value="ホーム">
</form>
<input class="header__link" type="date" name="date" value="日付一覧">
<form action="/logout" method="post">
    @csrf
    <input type="submit" class="header__link" value="ログアウト">
</form>
@endsection

@section('content')
<div class="content">
    <div class="content__heading">
        <p>福場凛太郎さん<!--$user('name')?-->お疲れ様です！</p>
    </div>
    <div class="main__inner">
        <div class="main__inner-work">
            <input type="submit" class="work-start" name="work-start" value="勤務開始">
            <input type="submit" class="work-end" name="work-end" value="勤務終了">
        </div>
        <div class="main__inner-breaking">
            <input type="submit" class="breaking-start" name="breaking-start" value="休憩開始">
            <input type="submit" class="breaking-end" name="breaking-end" value="休憩終了">
        </div>
    </div>
</div>
@endsection