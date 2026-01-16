@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/edit.css') }}">
@endsection

@section('header-button')
@endsection

@section('content')
<div class="profile-edit">
    <div class="profile-edit__container">
        <h1 class="profile-edit__title">プロフィール設定</h1>
        <form class="profile-edit__form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="profile-edit__inner">
                <div class="profile-edit__avatar-field">
                    @if ($profile && $profile->img_path)
                    <img class="profile-edit__avatar-preview" data-preview-class="profile-edit__avatar-preview" id="preview" src="{{ asset('storage/'.$profile->img_path) }}" alt="{{ $user->name }}">
                    @else
                    <div class="profile-edit__avatar-preview profile-edit__avatar--noimg" data-preview-class="profile-edit__avatar-preview"
                        id="preview" aria-label="{{ $user->name }}"></div>
                    @endif
                    <label class="profile-edit__label--image">画像を選択する<input class="profile-edit__image-input" type="file" id="imageInput" name="img_path"></label>
                </div>
                <div class="profile-edit__field">
                    <label class="profile-edit__label" for="name">ユーザー名</label>
                    <input class="profile-edit__input" type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
                    <div class="form__error">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-edit__field">
                    <label class="profile-edit__label" for="postal_code">郵便番号</label>
                    <input class="profile-edit__input" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}">
                    <div class="form__error">
                        @error('postal_code')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-edit__field">
                    <label class="profile-edit__label" for="address">住所</label>
                    <input class="profile-edit__input" type="text" id="address" name="address" value="{{ old('address', $profile->address) }}">
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="profile-edit__field">
                    <label class="profile-edit__label" for="building">建物名</label>
                    <input class="profile-edit__input" type="text" id="building" name="building" value="{{ old('building', $profile->building) }}">
                </div>
                <div class="profile-edit__action">
                    <button class="profile-edit__submit" type="submit">更新する</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection