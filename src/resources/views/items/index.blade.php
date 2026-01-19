@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
    <div class="item-top__head container--narrow">
        <div class="item-top__head-inner">
            <a href="{{ request('keyword') ? url('/?keyword=' . request('keyword')) : url('/') }}" class="item-top__tab {{ $tab === 'recommend' ? 'is-active' : '' }}">
                おすすめ
            </a>

            <a href="{{ request('keyword') ? url('/?tab=mylist&keyword=' . request('keyword')) : url('/?tab=mylist') }}" class="item-top__tab {{ $tab === 'mylist' ? 'is-active' : '' }}">
                マイリスト
            </a>

            @if (request('keyword'))
                <p class="item-search__result">{{ $items->count() }}件ヒットしました</p>
            @endif
        </div>
    </div>
    
    <div class="item-top__main container">
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