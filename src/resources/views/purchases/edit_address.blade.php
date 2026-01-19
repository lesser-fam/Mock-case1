@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
    <div class="container--form">

        <h1 class="form__heading">住所の変更</h1>
            
        <form class="form" action="{{ route('purchase.address.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
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
@endsection