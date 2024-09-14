@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/show.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_owner')
@endcomponent
<div class="shop-edit">
    <div class="shop-edit__name">
        @if ($owner && $owner->name)
        <h2>{{ $owner->name }}さん</h2>
        @endif
    </div>
    <div class="container">
        <div class="card">
            <div class="card-content">
                <div class="card-content__img">
                    <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300" height="200">
                </div>
                <div class="card-content__ttl">
                    <h2>{{ $shop->shop_name }}</h2>
                </div>
                <div class="card-content__tag">
                    <p>#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                </div>
                <div class="card-content__overview">
                    <p>{{ $shop->overview }}</p>
                </div>
            </div>
        </div>
        <form class="editShopForm" action="{{ route('editShop') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $shop->id }}">
            <div class="form__ttl">
                <h2>Shop編集</h2>
            </div>
            <div class="form__flash_message">
                @if (session('message'))
                {{ session('message') }}
                @endif
            </div>
            <div class="form-group">
                <label for="shop_name">Shop Name</label>
                <input type="text" name="shop_name" class="form-group__input" value="{{ $shop->shop_name }}">
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
                    <option value="{{ $area->id }}" {{ $shop->area_id == $area->id ? 'selected' : '' }}>{{ $area->name
                        }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="genre_id">Genre</label>
                <select name="genre_id" class="form-group__select">
                    @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $shop->genre_id == $genre->id ? 'selected' : '' }}>{{
                        $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-overview">
                <label for="overview">Overview</label>
                <textarea name="overview" rows="10" class="form-group__textarea">{{ $shop->overview }}</textarea>
            </div>
            <div class="form-group__error-message">
                @error('overview')
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
