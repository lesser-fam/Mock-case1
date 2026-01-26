@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profiles/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profiles/mypage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items/item_card.css') }}">
@endsection

@section('content')
    <div class="container--profile">
        <div class="profile-user">
            <div class="profile-user__image">
                <img src="{{ optional($profile)->image ? asset('storage/' . $profile->image) : asset('/images/default.png') }}" alt="ユーザー画像">
            </div>
            <p class="profile-user__name">
                {{ optional($profile)->user_name ?? '未設定' }}
            </p>
        </div>
        <a class="profile-action__edit-link" href="{{ route('mypage.profile.edit') }}">プロフィールを編集</a>
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
            <a class="item-card" href="{{ route('items.show', $item->id) }}">
                <div class="item-card__image">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                    @if ($item->purchase && $item->purchase->status === 'paid')
                        <span class="badge--sold">SOLD</span>
                    @endif
                </div>
                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
@endsection