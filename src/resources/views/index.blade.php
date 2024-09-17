@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
<div class="content">
    {{-- 検索、並び替えフォーム --}}
    <div class="flex search-box">
        <form class="sort__form" id="sortForm" action="{{ route('index') }}" method="GET">
            <select name="sort" id="sortSelect">
                <option value="" disabled selected class="hidden">並び替え:評価高/低</option>
                <option value="high" {{ request('sort')=='high' ? 'selected' : '' }}>評価の高い順</option>
                <option value="low" {{ request('sort')=='low' ? 'selected' : '' }}>評価の低い順</option>
                <option value="random" {{ request('sort')=='random' ? 'selected' : '' }}>ランダム</option>
            </select>
        </form>
        <form class="search__form" action="/search" method="get">
            <select class="search__form--select-area" name="area_id" id="area_id">
                <option value="" {{ request('area_id')=='' ? 'selected' : '' }}>All area</option>
                @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ request('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name
                    }}
                </option>
                @endforeach
            </select>
            <span class="search__form--span">|</span>
            <select class="search__form--select-genre" name="genre_id" id="genre_id">
                <option value="" {{ request('genre_id')=='' ? 'selected' : '' }}>
                    All genre</option>
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre_id')==$genre->id ? 'selected' : '' }}>{{
                    $genre->name
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
    {{-- shop一覧画面 --}}
    <div class="cards">
        <div class="cards__grid-parent">
            @foreach ($shops as $shop)
            <div class="practice__card">
                <img class="card__img" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300"
                    height="200">
                <div class="card__article">
                    <div class="card__ttl">
                        <h2>{{ $shop->shop_name }}</h2>
                    </div>
                    <div class="tag">
                        <p class="card__tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                    </div>
                    <div class="flex justify-between card__button">
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
        </div>
    </div>
</div>
<div class="error-message">
    @if(isset($message))
    {{ $message }}
    @endif
</div>
<script src="/js/heart.js" defer></script>
<script>
    document.getElementById('sortSelect').addEventListener('change', function() {
        document.getElementById('sortForm').submit();
    });
</script>
@endsection
