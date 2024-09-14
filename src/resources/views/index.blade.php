@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav')
@endcomponent
@else
@component('components.nav_auth')
@endcomponent
@endif
<div class="content">
    <div class="content__search">
        <form class="search__form" action="/search" method="get">
            <select class="search__form--select-area" name="area_id" id="area_id">
                <option value="" {{ request('area_id')=='' ? 'selected' : '' }}>All area</option>
                @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ request('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name }}
                </option>
                @endforeach
            </select>
            <span class="search__form--span">|</span>
            <select class="search__form--select-genre" name="genre_id" id="genre_id">
                <option value="" {{ request('genre_id')=='' ? 'selected' : '' }}>
                    All genre</option>
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre_id')==$genre->id ? 'selected' : '' }}>{{ $genre->name
                    }}</option>
                @endforeach
            </select>
            <span class="search__form--span">|</span>
            <button class="search__form--button">
                <i class="bi bi-search" id="search"></i>
            </button>
            <input class="search__form--input" type="text" name="shop_name" value="{{ request('shop_name') }}"
                placeholder="Search ...">
        </form>
    </div>
    <div class="card">
        <div class="card-content">
            @foreach ($shops as $shop)
            <div class="practice__card">
                <div class="card__img">
                    <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300" height="200">
                </div>
                <div class="card__article">
                    <div class="card__ttl">
                        <h2>{{ $shop->shop_name }}</h2>
                    </div>
                    <div class="tag">
                        <p class="card__tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                    </div>
                    <div class="card__button">
                        <a class="card__button--link" href="{{ route('detail', $shop->id) }}">詳しくみる</a>
                        @if( Auth::check() )
                        @php
                        $isFavorite = in_array($shop->id, $favorites);
                        @endphp
                        <div class="heart {{ $isFavorite ? 'heart_true' : 'heart_false' }}"
                            data-shop-id="{{ $shop->id }}"><i class="bi bi-suit-heart-fill" id="heart"></i></div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            <script src="/js/heart.js"></script>
        </div>
    </div>
</div>
<div class="error__message">
    @if(isset($message))
    {{ $message }}
    @endif
</div>

@endsection
