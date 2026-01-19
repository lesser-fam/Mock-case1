@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <p>
        登録していただいたメールアドレスに認証メールを送付しました。
        メール認証を完了してください。
    </p>

    @if (session('resent'))
        <p>認証メールを再送信しました。</p>
    @endif

    <a href="http://localhost:8025" target="_blank">
        認証はこちらから
    </a>

    <form action="/email/verification-notification" method="POST">
        @csrf
        <button type="submit">認証メールを再送する</button>
    </form>

@endsection