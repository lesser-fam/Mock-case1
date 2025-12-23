@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="register-form">
        <h1 class="register-form__heading">会員登録</h1>
            
                <form class="register-form__form" action="{{ route('register') }}" method="POST" novalidate>
                    @csrf
                    <div class="form__group">
                        <label class="form__label" for="user_name">ユーザー名</label>
                        <input class="form__input" type="text" name="user_name" id="user_name" maxlength="20" value="{{ old('user_name') }}">
                        <p class="form__error">
                            @error('user_name')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
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
                                @if ($message !== 'パスワードと一致しません')
                                    {{ $message }}
                                @endif
                            @enderror
                        </p>
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="password_confirmation">確認用パスワード</label>
                        <input class="form__input" type="password" name="password_confirmation" id="password_confirmation">
                        <p class="form__error">
                            @error('password')
                                @if ($message === 'パスワードと一致しません')
                                    {{ $message }}
                                @endif
                            @enderror
                        </p>
                    </div>
                    <div class="">
                        <input class="btn register-btn" type="submit" value="登録する">
                        <a class="form__link" href="{{ route('login') }}">ログインはこちら</a>
                    </div>
                </form>
            
    </div>
@endsection