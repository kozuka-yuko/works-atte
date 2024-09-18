@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/person-work.css') }}" />
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
    <div class="header__link">
        <a href="/all-member" class="header__link--inner">登録会員一覧</a>
    </div>
    <form action="/logout" method="post">
        @csrf
        <input type="submit" class="header__link" value="ログアウト" />
    </form>
</div>
@endsection

@section('content')
<div class="content">
    <table class="work__table">
        <tr class="table__row">
            <th class="table__label">
                名前
            </th>
            <th class="table__label">
                勤務開始
            </th>
            <th class="table__label">
                勤務終了
            </th>
            <th class="table__label">
                休憩時間</th>
            <th class="table__label">
                勤務時間
            </th>
        </tr>
        @foreach($works as $work)
        <tr class="table__row">
            <td class="work__data">
                {{ $work->user->name }}
            </td>
            <td class="work__data">
                {{ $work->work_start }}
            </td>
            <td class="work__data">
                {{ ($work->work_end === null || $work->work_end === '00:00:00') ? ' ' : $work->work_end }}
            </td>
            <td class="work__data">
                {{ ($work->allbreaking_time === null || $work->allbreaking_time === '00:00:00') ? ' ' : $work->allbreaking_time }}
            </td>
            <td class="work__data">
                {{ ($work->work_time === null || $work->work_time === '00:00:00') ? ' ' : $work->work_time }}
            </td>
        </tr>
        @endforeach
    </table>
    {{ $works->links() }}
</div>

@endsection