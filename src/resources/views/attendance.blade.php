@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('link')
<form action="" class="home__button">
    @csrf
    <input type="submit" class="header__link" value="ホーム" />
</form>
<input class="header__link" type="date" name="date" value="日付一覧" />
<form action="" method="post">
    @csrf
    <input type="submit" class="header__link" value="ログアウト" />
</form>
@endsection

@section('content')
<div class="content">
    <div class="content__heading">
        <input type="date" class="content__date" name="content__date" value="{{ $request('work_date') }}" />
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
                {{ $work->start_time }}
            </td>
            <td class="attendance__data">
                {{ $work->end_time }}
            </td>
            @endforeach
            @foreach($breakings as $breaking)
            <td class="attendance__data">
                {{ $breaking-> <!--時間の差と休憩回数分の合計時間定義せねば-->}}
            </td>
            @endforeach
            @foreach($works as $work)
            <td class="attendance__data">
                {{ $work-><!--勤務終了－勤務開始時間を定義する--> }}
            </td>
            @endforeach
        </tr>
    </table>
    {{ $works->links() }}
</div>
@endsection