@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container--form">

        <h1 class="form__heading">プロフィール設定</h1>
            
        <form class="form" action="{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form__group profile__image-group">
                <div class="profile__image-wrap">
                    <img class="profile__image" src="{{ $profile && $profile->image ? asset('storage/' . $profile->image) : asset('/images/default.png') }}" alt="ユーザー画像">
                </div>
                
                <label class="profile__image-btn" for="profile_image">
                    画像を選択する
                </label>

                <input id="profile_image" class="profile__image-input" type="file" name="image" accept="image/*">
            </div>

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
                    
            <input class="btn" type="submit" value="更新する">
        </form>
    </div>

<script>
    document.getElementById('profile_image').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const img = document.querySelector('.profile__image');
            img.src = URL.createObjectURL(this.files[0]);
        }
    });
</script>
@endsection