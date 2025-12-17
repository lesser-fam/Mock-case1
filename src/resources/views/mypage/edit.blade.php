@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
@endsection

@section('content')
    <div class="edit-profile">
        <h2 class="edit-profile__heading">プロフィール設定</h2>
            <div class="edit-profile__inner">
                <form class="edit-profile__form" action="/" method="POST">
                    @csrf
                    <div class="form__group edit-profile__group">
                        <label class="form__label edit-profile__label" for="user_name">ユーザー名</label>
                        <input class="form__input edit-profile__input" type="text" name="user_name" id="user_name" value="{{ old('user_name') }}">
                        <p class="form__error">
                            @error('user_name')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group edit-profile__group">
                        <label class="form__label edit-profile__label" for="post_num">郵便番号</label>
                        <input class="form__input edit-profile__input" type="text" name="post_num" id="post_num" value="{{ old('post_num') }}">
                        <p class="form__error">
                            @error('post_num')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group edit-profile__group">
                        <label class="form__label edit-profile__label" for="address">住所</label>
                        <input class="form__input edit-profile__input" type="text" name="address" id="address" value="{{ old('address') }}">
                        <p class="form__error">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group edit-profile__group">
                        <label class="form__label edit-profile__label" for="building">建物名</label>
                        <input class="form__input edit-profile__input" type="text" name="building" id="building" value="{{ old('building') }}">
                        <p class="form__error">
                            @error('building')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="">
                        <input class="btn edit-profile__btn" type="submit" value="登録する">
                    </div>
                </form>
            </div>
    </div>
    <!-- 実行時にはこのログアウトボタンは消す -->
    <form method="POST" action="/logout">
    @csrf
    <button type="submit">ログアウト</button>
</form>
@endsection