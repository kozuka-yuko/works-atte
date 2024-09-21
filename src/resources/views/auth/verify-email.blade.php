@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="info">
        <h4 class="info__heading">メール認証が必要です</h4>
        <p class="message">アカウントを有効にするには、登録されたメールアドレスを確認してください。</p>
        <p class="message">確認メールが届かない場合は、以下のボタンを押して再送信してください。</p>
    </div>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="resend__button">確認メールを再送信する</button>
    </form>
</div>
@endsection