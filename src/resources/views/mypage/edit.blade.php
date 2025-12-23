@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
@endsection

@section('content')
    <div class="edit-profile">
        <h1 class="edit-profile__heading">プロフィール設定</h1>
            <div class="edit-profile__inner">
                <form class="edit-profile__form" action="{{ route('mypage.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="from" value="{{ $from }}">

                    <div class="form__group">
                        <label class="form__label" for="user_name">ユーザー名</label>
                        <input class="form__input" type="text" name="user_name" id="user_name" value="{{ old('user_name', $profile->user_name ?? '') }}">
                        <p class="form__error">
                            @error('user_name')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="post_num">郵便番号</label>
                        <input class="form__input" type="text" name="post_num" id="post_num" value="{{ old('post_num', $profile->post_num ?? '') }}">
                        <p class="form__error">
                            @error('post_num')
                            {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="address">住所</label>
                        <input class="form__input" type="text" name="address" id="address" value="{{ old('address', $profile->address ?? '') }}">
                        <p class="form__error">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="form__group">
                        <label class="form__label" for="building">建物名</label>
                        <input class="form__input" type="text" name="building" id="building" value="{{ old('building', $profile->building ?? '') }}">
                        <p class="form__error">
                            @error('building')
                                {{ $message }}
                            @enderror
                        </p>
                    </div>
                    <div class="">
                        <input class="btn edit-profile__btn" type="submit" value="更新する">
                    </div>
                </form>
            </div>
    </div>
@endsection