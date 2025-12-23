@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
    <div class="item-top__head">
        <div class="item-top__head-inner">
            <a href="{{ url('/') }}" class="item-top__head--recs {{ $tab === 'recommend' ? 'active' : '' }}">
            おすすめ
            </a>

            <a href="{{ url('/?tab=mylist') }}" class="item-top__head--mylist {{ $tab === 'mylist' ? 'active' : '' }}">
            マイリスト
            </a>
        </div>
    </div>
    
    <div class="item-top__main">
        @foreach ($items as $item)
            <a class="item-group" href="{{ route('items.show', $item->id) }}">
                <div class="item-group__image-wrap">
                    <img class="item-group__image" src="{{ $item->image }}" alt="{{ $item->name }}">

                    @if ($item->purchase)
                        <span class= "item-group__sold">SOLD</span>
                    @endif
                </div>

                <p class="item-group__name">{{ $item->name }}</p>
            </a>
        @endforeach
    </div>
@endsection