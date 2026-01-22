@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/items/item_sell.css') }}">
@endsection

@section('content')
    <div class="container--form">
        <h1 class="form__heading">商品の出品</h1>
            
        <form class="form" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <section class="item-sell__section">
                <label class="item-sell__group-title">商品画像</label>
                <div class="item-sell__image-area">
                    <p id="fileName" class="item-sell__file-name" hidden></p>
                    
                    <label class="item-sell__image-btn" for="item_image">
                        画像を選択する
                    </label>
                    <input id="item_image" type="file" name="image" accept="image/*" hidden>

                    <p class="item-sell__msg">
                        ※ 画像はエラー時に再選択が必要です
                    </p>
                </div>

                <p class="form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </p>
            </section>

            <section class="item-sell__section">
                <h2 class="item-sell__section-title">商品詳細</h2>

                <div class="item-sell__group">
                    <label class="item-sell__group-title">カテゴリー</label>
                    <div class="item-sell__categories">
                        @foreach ($categories as $category)
                            <input 
                                type="checkbox"
                                name="categories[]"
                                id="category_{{ $category->id }}"
                                value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                hidden
                            >
                            <label for="category_{{ $category->id }}" class="item-sell__category-tag">
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <p class="form__error">
                    @error('categories')
                        {{ $message }}
                    @enderror
                </p>

                <div class="item-sell__group">    
                    <label class="item-sell__group-title" for="condition">商品の状態</label>

                    <select id="condition" class="item-sell__input" name="condition">
                        <option value="">選択してください</option>
                        @foreach ($conditions as $condition)
                            <option
                                value="{{ $condition->id }}" {{ old('condition') == $condition->id ? 'selected' : '' }}>
                                {{ $condition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <p class="form__error">
                    @error('condition')
                        {{ $message }}
                    @enderror
                </p>
            </section>

            <section class="item-sell__section">
                <h2 class="item-sell__section-title">商品名と説明</h2>
                
                <div class="item-sell__group">
                    <label class="item-sell__group-title" for="name">商品名</label>
                    <input class="item-sell__input" type="text" name="name" id="name" value="{{ old('name') }}">
                    <p class="form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="item-sell__group">
                    <label class="item-sell__group-title" for="brand">ブランド名</label>
                    <input class="item-sell__input" type="text" name="brand" id="brand" value="{{ old('brand') }}">
                    <p class="form__error">
                        @error('brand')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="item-sell__group">
                    <label class="item-sell__group-title" for="detail">商品の説明</label>
                    <textarea class="item-sell__textarea" name="detail" id="detail" rows="4">{{ old('detail') }}</textarea>
                    <p class="form__error">
                        @error('detail')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div class="item-sell__group">
                    <label class="item-sell__group-title" for="price">販売価格</label>
                    <div class="price-input">
                        <span class="price-input__yen">¥</span>
                        <input class="price-input__field" type="number" name="price" id="price" value="{{ old('price') }}">
                    </div>
                        <p class="form__error">
                        @error('price')
                            {{ $message }}
                        @enderror
                    </p>
                </div>
            </section>

            <input class="btn btn--primary" type="submit" value="出品する">
        </form>
    </div>

<script>
    document.getElementById('item_image').addEventListener('change', function() {
        const fileNameElement = document.getElementById('fileName');

        if (this.files.length > 0) {
            fileNameElement.textContent = this.files[0].name;
            fileNameElement.removeAttribute('hidden');
        }
    });
</script>
@endsection