@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
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
<div class="content">
    <div class="content__heading">
        <span>
            <a href="{{ url('attendance?work_date=' .$prevDay) }}" class="prev-day">
                <</a>
        </span>
        <span class="current-date">{{ $date->format('Y-m-d') }}</span>
        <span>
            <a href="{{ url('attendance?work_date=' .$nextDay) }}" class="next-day">></a>
        </span>
    </div>
    <table class="attendance__table">
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
            <td class="attendance__data">
                {{ $work->user->name }}
            </td>
            <td class="attendance__data">
                {{ $work->work_start }}
            </td>
            <td class="attendance__data">
                {{ $work->work_end }}
            </td>
            <td class="attendance__data">
                {{ $work->allbreaking_time}}
            </td>
            <td class="attendance__data">
                {{ $work->work_time }}
            </td>
        </tr>
        @endforeach
    </table>
    {{ $works->links() }}
</div>
@endsection