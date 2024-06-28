@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login-form__heading">
        <h2>ログイン</h2>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__input">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
            </div>
            <div class="form__error">
                <!--バリデーションを実装したら記述します-->
            </div>
        </div>
        <div class="form__group">
            <div class="form__input">
                <input type="password" name="password" placeholder="パスワード" />
            </div>
            <div class="form__error">
                <!--バリデーションを実装したら記述します-->
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログイン</button>
        </div>
    </form>
    <div class="register__link">
        <div class="register__link-title">
            <p>アカウントをお持ちでない方はこちらから</p>
        </div>
        <div class="register__link-submit">
            <a href="/register">会員登録</a>
        </div>
    </div>
</div>
@endsection