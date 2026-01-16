@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/shipping_address_edit.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="shipping-address-edit">
    <div class="shipping-address-edit__container">
        <h1 class="shipping-address-edit__title">住所の変更</h1>
        <form class="shipping-address-edit__form" action="{{ route('purchase.address.update', $item_id) }}" method="post" novalidate>
            @csrf
            <div class="shipping-address-edit__inner">
                <div class="shipping-address-edit__field">
                    <label class="shipping-address-edit__label" for="postal_code">郵便番号</label>
                    <input class="shipping-address-edit__input" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                    <div class="form__error">
                        @error('postal_code')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shipping-address-edit__field">
                    <label class="shipping-address-edit__label" for="address">住所</label>
                    <input class="shipping-address-edit__input" type="text" id="address" name="address" value="{{ old('address') }}">
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="shipping-address-edit__field">
                    <label class="shipping-address-edit__label" for="building">建物名</label>
                    <input class="shipping-address-edit__input" type="text" id="building" name="building" value="{{ old('building') }}">
                </div>
                <div class="shipping-address-edit__action">
                    <button class="shipping-address-edit__submit" type="submit">更新する</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection