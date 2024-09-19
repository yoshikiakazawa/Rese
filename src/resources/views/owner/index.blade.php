@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_owner')
@endcomponent
<div class="shop-list">
    @if ($owner && $owner->name)
    <h2 class="shop-list__owner-name">name:{{ $owner->name }}さん</h2>
    @endif
    <h3 class="shop-list__ttl">ShopList</h3>
    <div class=" flash-message">
        @if ($shops->isEmpty())
        <p>店舗が登録されていません。</p>
        @endif
    </div>
    
    {{-- shop作成フォーム --}}
    <div class="flex wrap justify-center">
        <form class="createShopForm" action="{{ route('storeShop') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between align-items-center">
                <h2 class="createShopForm__ttl">CreateShopForm</h2>
                <div class="flash-message">
                    @if (session('flash-message'))
                    {{ session('flash-message') }}
                    @endif
                </div>
            </div>
            <div class="flex align-items-center">
                <label class="createShopForm__label" for="shop_name">shop_name</label>
                <input type="text" name="shop_name" class="createShopForm__input-text" value="{{ old('shop_name') }}">
            </div>
            <div class="error-message">
                @error('shop_name')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="flex align-items-center">
                <label class="createShopForm__label" for="area_id">Area</label>
                <select name="area_id" class="createShopForm__select">
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name
                        }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex align-items-center">
                <label class="createShopForm__label" for="genre_id">Genre</label>
                <select name="genre_id" class="createShopForm__select">
                    @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ old('genre_id')==$genre->id ? 'selected' : '' }}>{{
                        $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-column">
                <label class="createShopForm__label" for="overview">Overview</label>
                <textarea class="createShopForm__overview" name="overview">{{ old('overview') }}</textarea>
            </div>
            <div class="error-message">
                @error('overview')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <input class="createShopForm-image" type="file" name="image">
            <div class="error-message">
                @error('image')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="createShopForm__btn--submit">登録</button>
        </form>

        {{-- shopリスト --}}
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
            <div class="flex justify-center">
                <textarea class="card-content__overview" readonly>{{ $shop->overview }}</textarea>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
