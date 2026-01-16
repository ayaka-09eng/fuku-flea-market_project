@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="items">
    <ul class="items__nav-tabs">
        <li class="items__nav-item">
            <a class="items__nav-link {{ $tab === 'recommend' ? 'active' : '' }}" href="{{ url('/?tab=recommend&keyword=' . $keyword) }}">おすすめ</a>
        </li>
        <li class="items__nav-item">
            <a class="items__nav-link {{ $tab === 'mylist' ? 'active' : '' }}" href="{{ url('/?tab=mylist&keyword=' . $keyword) }}">マイリスト</a>
        </li>
    </ul>
    <hr class="items__nav-underline">
    <div class="items__grid">
        @foreach($items as $item)
        <a class="items__card" href="{{ route('items.show', $item) }}">
            <img class="items__image" src="{{ asset('/storage/'.$item->img_path) }}" alt="商品画像">
            @if($item->is_sold)
            <span class="items__sold-badge">Sold</span>
            @endif
            <p class="items__name">{{ $item->name }}</p>
        </a>
        @endforeach
    </div>
</div>
@endsection