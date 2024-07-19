@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('link')
<form action="/" method="get">
    @csrf
    <input type="submit" class="header__link" value="ホーム" />
</form>
<div class="header__link">
    <a href="/attendance">日付一覧</a>
</div>
<form action="/logout" method="post">
    @csrf
    <input type="submit" class="header__link" value="ログアウト" />
</form>
@endsection

@section('content')
<div class="content">
    <div class="content__heading">
        <input type="date" class="content__date" name="content__date" value="" />
        <!--↑ここの実装なぞ！-->
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
        <tr class="table__row">
            @foreach($works as $work)
            <td class="attendance__data">
                {{ $work->user_id }}
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
            @endforeach
        </tr>
    </table>
    {{ $works->links() }}
</div>
@endsection