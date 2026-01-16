@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/mypage.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__container">
        <div class="mypage__header">
            <div class="mypage__avatar">
                @if ($profile && $profile->img_path)
                <img class="mypage__avatar-img" src="{{ asset('storage/'.$profile->img_path) }}" alt="{{ $user->name }}">
                @else
                <div class="mypage__avatar-img mypage__avatar-img--noimg" aria-label="{{ $user->name }}"></div>
                @endif
                <span class="mypage__user-name">{{ $user->name }}</span>
            </div>
            <div class="mypage__edit">
                <a class="mypage__edit-link" href="{{ route('profile.edit') }}">プロフィールを編集</a>
            </div>
        </div>
        <ul class="mypage__tabs">
            <li class="mypage__tab-item">
                <a class="mypage__tab-link {{ $page === 'sell' ? 'active' : '' }}" href="{{ url('/mypage?page=sell') }}">出品した商品</a>
            </li>
            <li class="mypage__tab-item">
                <a class="mypage__tab-link {{ $page === 'buy' ? 'active' : '' }}" href="{{ url('/mypage?page=buy') }}">購入した商品</a>
            </li>
        </ul>
        <hr class="mypage__nav-underline">
        <div class="mypage__items">
            @foreach($items as $item)
            <a class="mypage__item-card" href="{{ route('items.show', $item) }}">
                <img class="mypage__item-img" src="{{ asset('/storage/'.$item->img_path) }}" alt="商品画像">
                @if($item->is_sold)
                <span class="mypage__sold-badge">Sold</span>
                @endif
                <p class="mypage__item-name">{{ $item->name }}</p>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection