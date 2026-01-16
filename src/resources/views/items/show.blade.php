@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__container">
        <div class="item-detail__image-wrapper">
            <img class="item-detail__img" src="{{ asset('/storage/'.$item->img_path) }}" alt="商品画像">
        </div>
        <div class="item-detail__info">
            <h1 class="item-detail__title">{{ $item->name }}</h1>
            <div class="item-detail__brand-wrapper">
                <span class="item-detail__brand">{{ $item && $item->brand ? $item->brand : '' }}</span>
            </div>
            <div class="item-detail__price-wrapper">
                <span class="item-detail__price">￥{{ number_format($item->price) }}(税込)</span>
            </div>
            <div class="item-detail__social">
                <div class="item-detail__likes-wrapper">
                    <button class="item-detail__likes-button" id="like-button" data-id="{{ $item->id }}">
                        @if ($item->likes->contains(auth()->id()))
                        <img class="item-detail__likes-icon" id="like-icon" src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね">
                        @else
                        <img class="item-detail__likes-icon" id="like-icon" src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね済み">
                        @endif
                    </button>
                    <span class="item-detail__likes-count" id="like-count">{{ $item->likes->count() }}</span>
                </div>
                <div class="item-detail__comment-wrapper">
                    <img class="item-detail__comment-icon" src="{{ asset('images/ふきだしロゴ.png') }}" alt="コメント">
                    <span class="item-detail__comment-count">{{ $item->comments->count() }}</span>
                </div>
            </div>
            <div class="item-detail__button-wrapper">
                @if ($item->is_sold)
                <span class="item-detail__purchase-button--sold">Sold</span>
                @else
                <a class="item-detail__purchase-button" href="{{ route('purchase.create', $item->id) }}" target="_blank" rel="noopener">購入手続きへ</a>
                @endif
            </div>
            <div class="item-detail__section-title-wrapper">
                <h2 class="item-detail__section-title">商品説明</h2>
                <p class="item-detail__description">{{ $item->description }}</p>
            </div>
            <div class="item-detail__section-title-wrapper">
                <h2 class="item-detail__section-title">商品の情報</h2>
                <div class="item-detail__categories">
                    <span class="item-detail__label">カテゴリー</span>
                    <div class="item-detail__category-list">
                        @foreach ($item->categories as $category)
                        <div class="item-detail__category-wrapper">
                            <span class="item-detail__category">{{ $category->content }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="item-detail__condition">
                    <span class="item-detail__label">商品の状態</span>
                    <span class="item-detail__condition-value">{{ $item->condition_label }}</span>
                </div>
            </div>
            <div class="item-detail__section-title-wrapper">
                <h2 class="item-detail__section-title--comment">コメント({{ $item->comments->count() }})</h2>
                <div class="item-detail__comments">
                    @foreach ($item->comments as $comment)
                    <div class="item-detail__comment">
                        <div class="item-detail__comment-header">
                            @if ($comment->user->profile && $comment->user->profile->img_path)
                            <img class="item-detail__comment-user-img" src="{{ asset('storage/'.$comment->user->profile->img_path) }}" alt="{{ $comment->user->name }}">
                            @else
                            <div class="item-detail__comment-user-img item-detail__comment-user-img--noimg" aria-label="{{ $comment->user->name }}"></div>
                            @endif
                            <span class="item-detail__comment-user-name">{{ $comment->user->name }}</span>
                        </div>
                        <p class="item-detail__comment-body">{{ $comment->body }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <form class="item-detail__comment-form" action="{{ route('comments.store', $item->id) }}" method="post">
                @csrf
                <label class="item-detail__comment-label" for="body">商品へのコメント</label>
                <textarea class="item-detail__comment-input" name="body" id="body">{{ old('body') }}</textarea>
                <div class="form__error">
                    @error('body')
                    {{ $message }}
                    @enderror
                </div>
                <button class="item-detail__comment-submit" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/like.js') }}"></script>
@endsection