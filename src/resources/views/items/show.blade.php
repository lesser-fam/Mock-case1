@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item_show.css') }}">
@endsection

@section('content')
    <div class="item-detail container--narrow">

        <div class="item-detail__left">
            <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
            
            @if ($item->purchase && $item->purchase->status === 'paid')
                <span class= "item-group__sold">SOLD</span>
            @endif
        </div>
        
        <div class="item-detail__right">
            <section class="item-summary">
                <h1>{{ $item->name }}</h1>
                <p class="item-brand">{{ $item->brand ?? '' }}</p>
                <p class="item-price">¥{{ number_format($item->price) }} <span>(税込)</span></p>
            </section>

            <section class="item-purchase">
                <div class="item-action__group">
                    <div class="item-action item-action__favorite">
                        @auth
                            <form action="{{ route('items.favorite', $item->id) }}" method="POST">
                                @csrf
                                <button class="icon-button" type="submit">
                                    @if ($isFavorited)
                                        <img src="/images/heart_pink.png" alt="いいね済み">
                                    @else
                                        <img src="/images/heart_def.png" alt="いいね">
                                    @endif
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}">
                                <img src="/images/heart_def.png" alt="いいね">
                            </a>
                        @endauth
                        <span>{{ $item->favorites->count() }}</span>
                    </div>

                    <div class="item-action item-action__comment">
                        <a href="#comments">
                            <img src="/images/speech_bubble.png" alt="コメント">
                        </a>
                        <span>{{ $item->comments->count() }}</span>
                    </div>
                </div>

                @if ($item->purchase && $item->purchase->status === 'paid')
                    <div class="btn btn-buy__sold">
                        売り切れました
                    </div>
                @else
                    @auth
                        <a href="{{ route('purchase.show', $item->id) }}" class="btn btn-buy">
                            購入手続きへ
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-buy">
                            購入手続きへ
                        </a>
                    @endauth
                @endif
            </section>

            <section class="item-description">
                <h2>商品説明</h2>
                <p class="item-explain">{!! nl2br(e($item->detail)) !!}</p>

                <h2>商品の情報</h2>
                <div class="item-info">
                    <h3 class="item-info__title">カテゴリー</h3>
                    <div class="item-info__categories">
                        @foreach ($item->categories as $category)
                            <div class="item-info__category">
                                {{ $category->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="item-info">    
                    <h3 class="item-info__title">商品の状態</h3>
                    <p class="item-info__value">{{ $item->condition->name }}</p>
                </div>
            </section>

            <section class="item-comments">
                <h2 class="comment">コメント({{ $item->comments->count() }})</h2>
                    @foreach ($item->comments as $comment)
                    <div class="comment__group">
                        <div class="comment__header">
                            <img class="comment__image" src="{{ $comment->user->profile && $comment->user->profile->image ? asset('storage/' . $comment->user->profile->image) : asset('/image/default.png') }}" alt="画像">
                            <span class="comment__name">
                                {{ $comment->user->profile->user_name }}
                            </span>
                        </div>

                        <div class="comment__body">
                            {!! nl2br(e($comment->detail)) !!}
                        </div>
                    </div>
                    @endforeach
       
                <h3 id="comments">商品へのコメント</h3>
                    @auth
                        <form action="{{ route('items.comment', $item->id) }}" method="POST">
                        @csrf
                            <p class="form__error">
                                @error('detail')
                                    {{ $message }}
                                @enderror
                            </p>
                                
                            <textarea name="detail">{{ old('detail') }}</textarea>
                            <button class="btn btn-comment" type="submit">コメントを送信する</button>
                        </form>
                    @else
                        <textarea name="detail"></textarea>
                        <a href="{{ route('login') }}" class="btn btn-comment">
                            コメントを送信する
                        </a>
                    @endauth
            </section>
        </div>
    </div>
@endsection