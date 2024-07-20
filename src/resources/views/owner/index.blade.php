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
                <a class="card-content__link--edit" href="{{ route('showShop', $shop->id) }}"><i
                        class="bi bi-pencil-square"></a></i>
            </div>
            <div class="card-content__flex">
                <div class="card-content__tag">
                    <p>#{{ $shop->areas->name }} #{{ $shop->genres->name }}</p>
                </div>
                <a class="card-content__link--history" href="{{ route('reservationHistory', $shop->id) }}">予約</a>
            </div>
            <div class="card-content__overview">
                <p>{{ $shop->overview }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="container-storeShopForm">
        <form class="storeShopForm" action="{{ route('storeShop') }}" method="post">
            @csrf
            <div class="storeShopForm__ttl">
                <h2>Shop登録</h2>
            </div>
            <div class="storeShopForm__flash_message">
                @if (session('message'))
                {{ session('message') }}
                @endif
            </div>
            <div class="storeShopForm-group">
                <label for="shop_name">Name</label>
                <input type="text" name="shop_name" class="storeShopForm-group__input-text"
                    value="{{ old('shop_name') }}">
            </div>
            <div class="storeShopForm-group__error-message">
                @error('shop_name')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="storeShopForm-group">
                <label for="area_id">Area</label>
                <select name="area_id" class="storeShopForm-group__select">
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name
                        }}</option>
                    @endforeach
                </select>
            </div>
            <div class="storeShopForm-group">
                <label for="genre_id">Genre</label>
                <select name="genre_id" class="storeShopForm-group__select">
                    @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ old('genre_id')==$genre->id ? 'selected' : '' }}>{{
                        $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="storeShopForm-group-overview">
                <label for="overview">Overview</label>
                <textarea name="overview" rows="10"
                    class="storeShopForm-group__textarea">{{ old('overview') }}</textarea>
            </div>
            <div class="storeShopForm-group__error-message">
                @error('overview')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="storeShopForm-group-image">
                <label for="image">Image</label>
                <p>形式:jpeg,png,jpg,gif,svg</br>幅:2048px以下</p>
                <input type="file" name="image" class="storeShopForm-group__input-file">
            </div>
            <div class="storeShopForm-group__error-message">
                @error('image')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="storeShopForm__btn">
                <button type="submit" class="storeShopForm__btn--submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
