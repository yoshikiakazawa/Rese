@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_owner')
@endcomponent
<div class="flex align-items-center justify-center shop-list__ttl">
    <h2>ShopList</h2>
    @if ($owner && $owner->name)
    <h2 class="shop-list__owner-name">owner name:{{ $owner->name }}さん</h2>
    @endif
    <div class="flash_message">
        @if ($shops->isEmpty())
        <p>店舗が登録されていません。</p>
        @endif
        @if (session('message'))
        {{ session('message') }}
        @endif
    </div>
</div>
<div class="flex align-items-center wrap shop-list">
    <form class="storeShopForm" action="{{ route('storeShop') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2 class="storeShopForm__ttl">登録Form</h2>
        <div class="flex">
            <label class="storeShopForm__label" for="shop_name">shop_name</label>
            <input type="text" name="shop_name" class="storeShopForm__input-text" value="{{ old('shop_name') }}">
        </div>
        <div class="error-message">
            @error('shop_name')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <div class="flex">
            <label class="storeShopForm__label" for="area_id">Area</label>
            <select name="area_id" class="storeShopForm__select">
                @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ old('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name
                    }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex">
            <label class="storeShopForm__label" for="genre_id">Genre</label>
            <select name="genre_id" class="storeShopForm__select">
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre_id')==$genre->id ? 'selected' : '' }}>{{
                    $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-column">
            <label class="storeShopForm__label" for="overview">Overview</label>
            <textarea name="overview" rows="10" class="storeShopForm__textarea">{{ old('overview') }}</textarea>
        </div>
        <div class="error-message">
            @error('overview')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <input class="storeShopForm-image" type="file" name="image">
        <div class="error-message">
            @error('image')
            <p>{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="storeShopForm__btn--submit">登録</button>
    </form>
    @foreach ($shops as $shop)
    <div class="card-content">
        <img class="card-content__img" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300"
            height="200">
        <div class="flex align-items-center justify-between card-content__ttl">
            <h2>{{ $shop->shop_name }}</h2>
            <a class="card-content__link--edit" href="{{ route('showShop', $shop->id) }}"><i
                    class="bi bi-pencil-square"></a></i>
        </div>
        <div class="flex align-items-center justify-between">
            <div class="card-content__tag">
                <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
            </div>
            <a class="card-content__link--history" href="{{ route('reservationHistory', $shop->id) }}">予約履歴</a>
        </div>
        <p class="card-content__overview">{{ $shop->overview }}</p>
    </div>
    @endforeach
    @endif
</div>
@endsection
