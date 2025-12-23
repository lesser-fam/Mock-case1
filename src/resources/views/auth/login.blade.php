@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="login-form">
        <h1 class="login-form__heading">ログイン</h1>
            
                <form class="login-form__form" action="{{ route('login') }}" method="POST" novalidate>
                    @csrf
                    <div class="form__group">
                        <label class="form__label" for="email">メールアドレス</label>
                        <input class="form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                        <p class="form__error">
                            @error('email')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="password">パスワード</label>
                        <input class="form__input" type="password" name="password" id="password">
                        <p class="form__error">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="">
                        <input class="btn login-btn" type="submit" value="ログインする">
                        <a class="form__link" href="{{ route('register') }}">会員登録はこちら</a>
                    </div>
                </form>
            
    </div>
@endsection