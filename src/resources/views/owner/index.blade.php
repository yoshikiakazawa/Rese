@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_owner')
@endcomponent
<div class="shop-list">
    <h2 class="shop-list__ttl">ShopList</h2>
    <div class="shop-list__name">
        @if ($owner && $owner->name)
        <h2>{{ $owner->name }}さん</h2>
        @endif
    </div>
    <div class="card">
        @if ($shops->isEmpty())
        <div class="card__empty-message">
            <p>店舗が登録されていません。</p>
        </div>
        @else
        @foreach ($shops as $shop)
        <div class="card-content">
            <div class="card-content__img">
                <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300" height="200">
            </div>
            <div class="card-content__ttl">
                <h2>{{ $shop->shop_name }}</h2>
                <div class="card-content__edit-link">
                    <a href="{{ route('showShop', $shop->id) }}"><i class="bi bi-pencil-square"></a></i>
                </div>
            </div>
            <div class="card-content__tag">
                <p>#{{ $shop->areas->name }} #{{ $shop->genres->name }}</p>
            </div>
            <div class="card-content__overview">
                <p>{{ $shop->overview }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="container-store-shop-form">
        {{-- <form action="{{ route('storeShop') }}" method="POST" enctype="multipart/form-data" class="store-shop-form"> --}}
            <form class="store-shop-form" action="{{ route('storeShop') }}" method="post">
                @csrf
                <div class="form__ttl">
                    <h2>Shop登録</h2>
                </div>
                <div class="form__flash_message">
                    @if (session('message'))
                    {{ session('message') }}
                    @endif
                </div>
                <div class="form-group">
                    <label for="shop_name">Shop Name</label>
                    <input type="text" name="shop_name" class="form-group__input-text" value="{{ old('shop_name') }}">
                </div>
                <div class="form-group__error-message">
                    @error('shop_name')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="area_id">Area</label>
                    <select name="area_id" class="form-group__select">
                        @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ old('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name
                            }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="genre_id">Genre</label>
                    <select name="genre_id" class="form-group__select">
                        @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id')==$genre->id ? 'selected' : '' }}>{{
                            $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group-overview">
                    <label for="overview">Overview</label>
                    <textarea name="overview" rows="10" class="form-group__textarea">{{ old('overview') }}</textarea>
                </div>
                <div class="form-group__error-message">
                    @error('overview')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group-image">
                    <label for="image">Image</label>
                    <p>形式:jpeg,png,jpg,gif,svg</br>幅:2048px以下</p>
                    <input type="file" name="image" class="form-group__input-file">
                </div>
                <div class="form-group__error-message">
                    @error('image')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form__btn">
                    <button type="submit" class="form__btn--submit">登録</button>
                </div>
            </form>
    </div>
</div>
@endif
@endsection
