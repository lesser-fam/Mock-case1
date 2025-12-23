@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
    <div class="item-detail">

        <div class="item-detail__left">
            <img src="{{ $item->image }}" alt="{{ $item->name }}">
        </div>
        
        <div class="item-detail__right">
            <h1>{{ $item->name }}</h1>
            <p class="item-brand">{{ $item->brand ?? '' }}</p>

            <p class="item-price">¥{{ number_format($item->price) }} (税込)</p>



            <button class="item-buy">購入手続きへ</button>

            <h2>商品説明</h2>
            <p>{{ $item->detail }}</p>

            <h2>商品の情報</h2>
            <ul class="item-info">
                <li>
                    <p class="item-info__title">カテゴリー</p>
                    <div class="item-categories">
                        @foreach ($item->categories as $category)
                            <div class="item-category">
                                {{ $category->name }}
                            </div>
                        @endforeach
                    </div>
                </li>

                <li>
                    <p class="item-info__title">状態</p>
                    <p class="item-info__value">{{ $item->condition->name }}</p>
                </li>
            </ul>

        <h2>コメント()</h2>
        

       
                <h3>商品へのコメント</h3>
                <textarea name="detail"></textarea>
                <button>コメントを送信する</button>
            

    </div>
@endsection