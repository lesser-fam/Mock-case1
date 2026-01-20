@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="mypage-profile container--form">
        <div class="mypage-user">
            <div class="mypage-user__image-wrap">
                <img class="mypage-user__image" src="{{ optional($profile)->image ? asset('storage/' . $profile->image) : asset('/images/default.png') }}" alt="ユーザー画像">
            </div>
            <p class="mypage-user__name">{{ optional($profile)->user_name ?? '未設定' }}</p>
        </div>

        <div>
            <a class="mypage-link" href="{{ route('mypage.profile.edit') }}">プロフィールを編集</a>
        </div>
    </div>

    <div class="mypage-head container--narrow">
        <div class="mypage-head__inner">
            <a href="{{ route('mypage.index', ['page' => 'sell']) }}" class="mypage__tab {{ $page === 'sell' ? 'is-active' : '' }}">
            出品した商品
            </a>

            <a href="{{ route('mypage.index', ['page' => 'buy']) }}" class="mypage__tab {{ $page === 'buy' ? 'is-active' : '' }}">
            購入した商品
            </a>
        </div>
    </div>
    
    <div class="mypage-main container">
        @foreach ($items as $item)
            <a class="item-group" href="{{ route('items.show', $item->id) }}">
                <div class="item-group__image-wrap">
                    <img class="item-group__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">

                    @if ($item->purchase && $item->purchase->status === 'paid')
                        <span class= "item-group__sold">SOLD</span>
                    @endif
                </div>

                <p class="item-group__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
@endsection