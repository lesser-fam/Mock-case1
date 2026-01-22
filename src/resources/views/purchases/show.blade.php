@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/forms/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchases/purchase.css') }}">
@endsection

@section('content')
<div class="purchase container--narrow">
    <form class="purchase-form" action="{{ route('purchase.store', $item->id) }}" method="POST">
        @csrf
        <div class="purchase-detail">
            <section class="purchase-section purchase-item">
                <div class="purchase-item__inner">
                    <div class="purchase-item__image-wrap">
                        <img class="purchase-item__image" src="{{ $item->image_url }}" alt="商品画像">
                    </div>

                    <div class="purchase-item__detail">
                        <p class="purchase-item__name">{{ $item->name }}</p>
                        <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>
            </section>

            <section class="purchase-section purchase-section--pay">
                <label for="paymentMethodSelect" class="purchase-section__title">
                    支払い方法
                </label>

                <div class="purchase-section__body">
                    <select name="payment_method" id="paymentMethodSelect" class="purchase-pay__select">
                        <option value="">選択してください</option>
                        @foreach ($paymentMethods as $key => $label)
                            <option value="{{ $key }}" {{ old('payment_method') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('payment_method')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <section class="purchase-section purchase-section--address">
                <div class="purchase-section__header">
                    <p class="purchase-section__title">配送先</p>
                    <a href="{{ route('purchase.address.edit', $item->id) }}" class="purchase-address__edit">
                        変更する
                    </a>
                </div>

                <div class="purchase-section__body">
                    <p><span>〒</span>{{ $address['post_num'] }}</p>
                    <p>{{ $address['address'] }}</p>
                    <p>{{ $address['building'] }}</p>

                    <input type="hidden" name="post_num" value="{{ $address['post_num'] }}">
                    <input type="hidden" name="address" value="{{ $address['address'] }}">
                    <input type="hidden" name="building" value="{{ $address['building'] }}">
                    
                    @error('post_num')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                    @error('address')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </section>
        </div>

        <div class="purchase-subtotal">
            <table class="purchase-summary">
                <tr>
                    <th>商品代金</th>
                    <td>¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td id="paymentMethodText">未選択</td>
                </tr>
            </table>

            <button class="btn btn--primary">購入する</button>
        </div>
    </form>
</div>

<script>
const select = document.getElementById('paymentMethodSelect');
const paymentText = document.getElementById('paymentMethodText');

function updatePaymentText() {
    const selectedOption = select.options[select.selectedIndex];
    paymentText.textContent = 
        selectedOption.value ? selectedOption.text : '未選択';
}

select.addEventListener('change', updatePaymentText);

updatePaymentText();
</script>
@endsection