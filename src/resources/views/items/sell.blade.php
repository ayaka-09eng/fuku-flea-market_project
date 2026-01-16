@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/sell.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="sell-page">
    <div class="sell-page__container">
        <h1 class="sell-page__title">商品の出品</h1>
        <form class="sell-form" action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="sell-form__inner">
                <div class="sell-form__field">
                    <label class="sell-form__label">商品画像</label>
                    <div class="sell-form__image-frame">
                        <img class="sell-form__img sell-form__img--hidden" id="preview" src="" alt="商品画像">
                        <label class="sell-form__image-label" id="imageLabel">画像を選択する<input class="sell-form__image-input" type="file" id="imageInput" name="img_path"></label>
                        <button class="sell-form__image-delete sell-form__image-delete--hidden" type="button" id="imageDelete">×</button>
                    </div>
                    <div class="form__error">
                        @error('img_path')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-page__section-container">
                    <h2 class="sell-page__section-title">商品の詳細</h2>
                    <hr class="sell-page__section-divider">
                </div>
                <div class="sell-form__field">
                    <label class="sell-form__label">カテゴリー</label>
                    <div class="sell-form__group">
                        @foreach ($categories as $category)
                        <label class="sell-form__category-item">
                            <input class="sell-form__category-select" type="checkbox" name="category_id[]" value="{{ $category->id }}"{{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }}>
                            <span class="sell-form__category-label">{{ $category->content }}</span>
                        </label>
                        @endforeach
                        <div class="form__error">
                            @error('category_id')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="sell-form__field">
                    <label class="sell-form__label" for="condition">商品の状態</label>
                    <select class="sell-form__condition-select" id="condition" name="condition">
                        <option value="">選択してください</option>
                        @foreach ($conditions as $id => $label)
                        <option value="{{ $id }}" {{ (string)old('condition') === (string)$id ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="form__error">
                        @error('condition')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-page__section-container">
                    <h2 class="sell-page__section-title">商品名と説明</h2>
                    <hr class="sell-page__section-divider">
                </div>
                <div class="sell-form__field">
                    <label class="sell-form__label" for="name">商品名</label>
                    <input class="sell-form__input" type="text" id="name" name="name" value="{{ old('name') }}">
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-form__field">
                    <label class="sell-form__label" for="brand">ブランド名</label>
                    <input class="sell-form__input" type="text" id="brand" name="brand" value="{{ old('brand') }}">
                    <div class="form__error">
                        @error('brand')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-form__field">
                    <label class="sell-form__label" for="description">商品の説明</label>
                    <textarea class="sell-form__description-input" id="description" name="description">{{ old('description') }}</textarea>
                    <div class="form__error">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-form__field">
                    <label class="sell-form__label" for="price">販売価格</label>
                    <input class="sell-form__input" type="number" id="price" name="price" value="{{ old('price') }}" placeholder="￥" min="0">
                    <div class=" form__error">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="sell-form__action">
                    <button class="sell-form__submit" type="submit">出品する</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection