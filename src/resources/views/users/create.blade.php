@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/create.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="profile-create">
    <div class="profile-create__container">
        <h1 class="profile-create__title">プロフィール設定</h1>
        <form class="profile-create__form" action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="profile-create__inner">
                <div class="profile-create__avatar-field">
                    <div class="profile-create__avatar-preview profile-create__avatar--noimg" data-preview-class="profile-create__avatar-preview" id="preview" aria-label="{{ $user->name }}"></div>
                    <label class="profile-create__label--image">画像を選択する<input class="profile-create__image-input" type="file" id="imageInput" name="img_path"></label>
                </div>
                <div class="profile-create__field">
                    <label class="profile-create__label" for="name">ユーザー名</label>
                    <input class="profile-create__input" type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-create__field">
                    <label class="profile-create__label" for="postal_code">郵便番号</label>
                    <input class="profile-create__input" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                    <div class="form__error">
                        @error('postal_code')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-create__field">
                    <label class="profile-create__label" for="address">住所</label>
                    <input class="profile-create__input" type="text" id="address" name="address" value="{{ old('address') }}">
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-create__field">
                    <label class="profile-create__label" for="building">建物名</label>
                    <input class="profile-create__input" type="text" id="building" name="building" value="{{ old('building') }}">
                </div>
                <div class="profile-create__action">
                    <button class="profile-create__submit" type="submit">更新する</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection