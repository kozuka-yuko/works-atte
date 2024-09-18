@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/all-member.css') }}" />
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
    <h2 class="title">登録会員一覧</h2>
    <form action="/all-member" class="search-form" method="get">
        <div class="search-form__item">
            <input type="text" class="search-form__name-input" name="name__input" placeholder="名前">
            <button class="search-form__button-submit" type="submit">検索</button>
        </div>
    </form>
    <div class="member__data">
        <table class="member-data__table">
            <tr class="table__row">
                <th class="table__label">名前</th>
                <th class="table__label">メールアドレス</th>
            </tr>
            @foreach ($users as $user)
            @if (is_object($user))
            <tr class="table__row">
                <td class="member__data">
                    <a href="{{ url('person-work?user_id=' . $user->id) }}" class="name">{{ $user->name }}</a>
                </td>
                <td class="member__data">
                    {{ $user->email }}
                </td>
            </tr>
            @else
            <tr class="table_row">
                <td colspan="2">ユーザー情報がありません。</td>
            </tr>
            @endif
            @endforeach
        </table>
    </div>
    {{ $users->links() }}
</div>

@endsection