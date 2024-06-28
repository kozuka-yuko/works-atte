@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register-form__heading">
        <h2>会員登録</h2>
    </div>
    <form action="/register" class="form" method="post">
        @csrf
        <div class="form__group">
            <div class="form__input">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="名前" />
            </div>
            <div class="form__error">
                <!--バリデーションした後に実装-->
            </div>
        </div>
        <div class="form__group">
            <div class="form__input">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
            </div>
            <div class="form__error">
                <!--バリデーションした後に実装-->
            </div>
        </div>
        <div class="form__group">
            <div class="form__input">
                <input type="password" name="password" placeholder="パスワード" />
            </div>
            <div class="form__error">
                <!--バリデーションした後に実装-->
            </div>
        </div>
        <div class="form__group">
            <div class="form__input">
                <input type="password" name="password_confirmation" placeholder="確認用パスワード" />
            </div>
            <div class="form__error">
                <!--バリデーションした後に実装-->
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">会員登録</button>
        </div>
    </form>
    <div class="login__link">
        <div class="login__link-title">
            <p>アカウントをお持ちの方はこちらから</p>
        </div>
        <div class="login__link-submit">
            <a href="/login">ログイン</a>
        </div>
    </div>
</div>
@endsection