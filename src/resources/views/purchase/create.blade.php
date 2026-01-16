@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/create.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="purchase">
    <form class="purchase__form" action="{{ route('purchase.store', ['item' => $item->id]) }}" method="post">
        @csrf
        <div class="purchase__detail">
            <div class="purchase__field">
                <img class="purchase__img" src="{{ asset('/storage/'.$item->img_path) }}" alt="商品画像">
                <div class="purchase__info">
                    <p class="purchase__name">{{ $item->name }}</p>
                    <p class="purchase__price">￥{{ number_format($item->price) }}</p>
                </div>
                <input type="hidden" name="price" value="{{ $item->price }}">
            </div>
            <hr class="purchase__section-divider">
            <div class="purchase__section-wrapper">
                <h1 class="purchase__section-title">支払い方法</h1>
                <select class="purchase__payment-select" name="payment_method" id="js-payment-select">
                    <option value="">選択してください</option>
                    @foreach ($paymentMethods as $id => $label)
                    <option value="{{ $id }}" {{ (string)old('payment_method') === (string)$id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('payment_method')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            <hr class="purchase__section-divider">
            <div class="purchase__section-wrapper">
                <div class="purchase__section-header">
                    <h1 class="purchase__section-title">配送先</h1>
                    <a class="purchase__address-change-link" href="{{ route('purchase.address.edit', $item->id) }}">変更する</a>
                </div>
                <div class="purchase__info">
                    <div class="purchase__postal-group">
                        <span class="purchase__prefix">〒 </span>
                        <input class="purchase__postal-code" type="text" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}" readonly>
                    </div>
                    <div class="purchase__address-group">
                        <input class="purchase__address" type="text" name="address" value="{{ old('address', $profile->address) }}" readonly>
                        @if ($profile->building)
                        <input class="purchase__building" type="text" name="building" value="{{ old('building', $profile->building) }}" readonly>
                        @endif
                    </div>
                </div>
                <div class="form__error-wrapper">
                    @error('postal_code')
                    <div class="form__error">{{ $message }}</div>
                    @enderror

                    @error('address')
                    <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <hr class="purchase__section-divider">
        </div>
        <aside class="purchase__summary">
            <div class="purchase__summary-box">
                <div class="purchase__summary-row">
                    <span class="purchase__summary-label">商品代金</span>
                    <p class="purchase__summary-price">￥{{ number_format($item->price) }}</p>
                </div>
                <div class="purchase__summary-row">
                    <span class="purchase__summary-label">支払い方法</span>
                    <p class="purchase__summary-method" id="js-summary-method">選択してください</p>
                </div>
            </div>
            <div class="purchase__summary-action">
                <button class="purchase__summary-submit" type="submit">購入する</button>
            </div>
        </aside>
    </form>
</div>
<script src="{{ asset('js/purchase.js') }}"></script>
@endsection