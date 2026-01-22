@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items/item_card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items/item_show.css') }}">
@endsection

@section('content')
    <div class="item-detail container--narrow">
        <div class="item-detail__image">
            <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
            
            @if ($item->purchase && $item->purchase->status === 'paid')
                <span class="badge--sold">SOLD</span>
            @endif
        </div>
        
        <div class="item-detail__content">
            <section class="item-summary">
                <h1 class="item-summary__name">{{ $item->name }}</h1>
                <p class="item-summary__brand">{{ $item->brand ?? '' }}</p>
                <p class="item-summary__price">¥{{ number_format($item->price) }} <span>(税込)</span></p>
            </section>

            <section class="item-purchase">
                <div class="item-action__group">
                    <div class="item-action item-action--favorite">
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

                    <div class="item-action item-action--comment">
                        <a href="#comments">
                            <img src="/images/speech_bubble.png" alt="コメント">
                        </a>
                        <span>{{ $item->comments->count() }}</span>
                    </div>
                </div>

                @if ($item->purchase && $item->purchase->status === 'paid')
                    <div class="btn btn--primary btn--disabled">
                        売り切れました
                    </div>
                @else
                    @auth
                        <a href="{{ route('purchase.show', $item->id) }}" class="btn btn--primary">
                            購入手続きへ
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn--primary">
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

            <section class="item-comment">
                <h2 class="item-comment__title">コメント({{ $item->comments->count() }})</h2>
                    @foreach ($item->comments as $comment)
                    <div class="item-comment__group">
                        <div class="item-comment__header">
                            <img class="item-comment__image" src="{{ $comment->user->profile && $comment->user->profile->image ? asset('storage/' . $comment->user->profile->image) : asset('/images/default.png') }}" alt="画像">
                            <span class="item-comment__name">
                                {{ optional($comment->user->profile)->user_name ?? 'ゲスト' }}
                            </span>
                        </div>

                        <div class="item-comment__body">
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
                                
                            <textarea class="item-comment__textarea" name="detail">{{ old('detail') }}</textarea>
                            <button class="btn--item btn--primary" type="submit">コメントを送信する</button>
                        </form>
                    @else
                        <textarea class="item-comment__textarea" name="detail"></textarea>
                        <a href="{{ route('login') }}" class="btn btn--primary">
                            コメントを送信する
                        </a>
                    @endauth
            </section>
        </div>
    </div>
@endsection