@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/work.css') }}" />
@endsection

@section('link')
<div class="link">
    <form action="/" class="home__button" method="get">
        @csrf
        <input type="submit" class="header__link" value="ホーム" />
    </form>
    <form action="/search" method="get">
        @csrf
        <input class="header__link" type="date" name="date" value="日付一覧" />
    </form>
    <form action="/logout" method="post">
        @csrf
        <input type="submit" class="header__link" value="ログアウト" />
    </form>
</div>
@endsection

@section('content')
<div class="content__heading">
    <p>福場凛太郎さんお疲れ様です！</p>
</div>
<div class="main__inner">
    <form action="/" class="work__button" method="post">
        @csrf
        <div class="main__inner-work">

            <input type="submit" class="work-start" name="work-start" value="勤務開始" />
            <input type="submit" class="work-end" name="work-end" value="勤務終了" />
        </div>
    </form>
    <form action="/" class="breaking__button" method="post">
        @csrf
        <div class="main__inner-breaking">
            <input type="submit" class="breaking-start" name="breaking-start" value="休憩開始" />
            <input type="submit" class="breaking-end" name="breaking-end" value="休憩終了" />
        </div>
    </form>
</div>

@endsection