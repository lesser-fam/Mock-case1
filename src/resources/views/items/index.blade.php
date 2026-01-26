@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/item.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items/item_card.css') }}">
@endsection

@section('content')
    <div class="item-tab__inner container--narrow">
        <div class="item-tab">
            <a href="{{ request('keyword') ? url('/?keyword=' . request('keyword')) : url('/') }}" class="item-tab__link {{ $tab === 'recommend' ? 'is-active' : '' }}">
                おすすめ
            </a>
            <a href="{{ request('keyword') ? url('/?tab=mylist&keyword=' . request('keyword')) : url('/?tab=mylist') }}" class="item-tab__link {{ $tab === 'mylist' ? 'is-active' : '' }}">
                マイリスト
            </a>
            @if (request('keyword'))
                <p class="item-tab__result">{{ $items->count() }}件ヒットしました</p>
            @endif
        </div>
    </div>
    <div class="item-list container">
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