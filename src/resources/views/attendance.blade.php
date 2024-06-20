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
            <td class="attendance__data">
                <input type="text" class="attendance__name" name="attendance__name" value="" />
            </td>
            <td class="attendance__data">
                <input type="text" class="attendance__work-start" name="attendance__work-start" value="" />
            </td>
            <td class="attendance__data">
                <input type="text" class="attendance__work-end" name="attendance__work-end" value="" />
            </td>
            <td class="attendance__data">
                <input type="text" class="attedance__breaking" name="attedance__breaking" value="" />
            </td>
            <td class="attendance__data">
                <input type="text" class="attendance__time" name="attendance__time" value="" />
            </td>
        </tr>
    </table>
    <!--ここにページネーション-->
</div>
@endsection