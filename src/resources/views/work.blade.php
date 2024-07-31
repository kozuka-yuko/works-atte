@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/work.css') }}" />
@endsection

@section('link')
<div class="link">
    <form action="/" method="get">
        @csrf
        <input type="submit" class="header__link" value="ホーム" />
    </form>
    <div class="header__link">
        <a href="/attendance" class="header__link--inner">日付一覧</a>
    </div>
    <form action="/logout" method="post">
        @csrf
        <input type="submit" class="header__link" value="ログアウト" />
    </form>
</div>
@endsection

@section('content')
<div class="content__heading">
    <p>{{ $user->name }}さんお疲れ様です！</p>
</div>
<div class="main__inner">
    <form action="/work_start" class="form" method="post">
        @csrf
        <div class="main__inner-work">
            @php 
            $isWorkStartDisabled = $isWorkStartDisabled ?? false;
            $isWorkEndDisabled = $isWorkEndDisabled ?? true;
            $isBreakingStartDisabled = $isBreakingStartDisabled ?? true;
            $isBreakingEndDisabled = $isBreakingEndDisabled ?? true;
            @endphp
            <input type="submit" {{$isWorkStartDisabled ? 'disabled' : '' }} class="work-start" name="work-start" value="勤務開始" />
        </div>
    </form>
    <form action="/work_end" class="form" method="post">
        @csrf
        <div class="main__inner-work">
            <input type="submit" {{$isWorkEndDisabled ? 'disabled' : '' }} class="work-end" name="work-end" value="勤務終了" />
        </div>
    </form>
</div>
<div class="main__inner">
    <form action="/breaking_start" class="form" method="post">
        @csrf
        <div class="main__inner-breaking">
            <input type="submit" {{$isBreakingStartDisabled ? 'disabled' : '' }} class="breaking-start" name="breaking-start" value="休憩開始" />
        </div>
    </form>
    <form action="/breaking_end" class="form" method="post">
        @csrf
        <div class="main__inner-breaking">
            <input type="submit" {{$isBreakingEndDisabled ? 'disabled' : '' }} class="breaking-end" name="breaking-end" value="休憩終了" />
        </div>
    </form>
</div>

@endsection