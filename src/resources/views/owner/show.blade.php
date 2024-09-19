@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/show.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_owner')
@endcomponent
<div class="shop-edit">
    <div class="shop__owner-name">
        @if ($owner && $owner->name)
        <h2>name:{{ $owner->name }}さん</h2>
        @endif
    </div>
    <div class="flex justify-center wrap">
        {{-- shop詳細 --}}
        <div class="shop-card">
            <img class="shop-card__img" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="400">
            <h2 class="shop-card__shop-name">{{ $shop->shop_name }}</h2>
            <p class="shop-card__tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
            <div class="flex justify-center">
                <textarea class="shop-card__overview" readonly>{{ $shop->overview }}</textarea>
            </div>
        </div>
        {{-- shop修正 --}}
        <form class="editShopForm" action="{{ route('editShop') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $shop->id }}">
            <h2 class="editShopForm__ttl">Shop編集</h2>
            <div class="flash-message">
                @if (session('flash-message'))
                {{ session('flash-message') }}
                @endif
            </div>
            <div class="flex align-items-center">
                <label class="editShopForm__label" for="shop_name">Shop Name</label>
                <input class="editShopForm__input" type="text" name="shop_name" value="{{ $shop->shop_name }}">
            </div>
            <div class="error-message">
                @error('shop_name')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="editShopForm__area flex align-items-center">
                <label class="editShopForm__label" for="area_id">Area</label>
                <select class="editShopForm__select" name="area_id">
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}" {{ $shop->area_id == $area->id ? 'selected' : '' }}>{{ $area->name
                        }}</option>
                    @endforeach
                </select>
            </div>
            <div class="editShopForm__genre flex align-items-center">
                <label class="editShopForm__label" for="genre_id">Genre</label>
                <select class="editShopForm__select" name="genre_id">
                    @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $shop->genre_id == $genre->id ? 'selected' : '' }}>{{
                        $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <label class="editShopForm__label-overview" for="overview">Overview</label>
            <div class="flex justify-center">
                <textarea class="editShopForm__textarea" name="overview">{{ $shop->overview }}</textarea>
            </div>
            <div class="error-message">
                @error('overview')
                <p>{{ $message }}</p>
                @enderror
            </div>
            <button class="editShopForm__btn--submit" type="submit">登録</button>
        </form>
    </div>
</div>
@endif
@endsection
