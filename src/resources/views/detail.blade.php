@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
    <div class="detail">
        <div class="detail__ttl">
            <a class="detail__ttl--link" href="/"><i class="bi bi-chevron-left"></i></a>
            <h2 class="detail__ttl--h2">{{ $shop->shop_name }}</h2>
        </div>
        <div class="detail__img">
            <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="100%">
        </div>
        <div class="detail__tag">
            <p class="detail__tag--p">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
        </div>
        <div class="detail__overview">
            <p class="detail__overview--p">{{ $shop->overview }}</p>
        </div>
    </div>
    @if(Auth::check())
    <form class="reservation-form" action="/done" method="post">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <div class="reservation-form__content">
            <div class="reservation-form__ttl">
                <h2 class="reservation-form__ttl--h2">予約</h2>
            </div>
            <div class="reservation-form__input">
                <input type="date" name="date" id="date">
                @error('date')
                <div class="reservation-form__error">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="reservation-form__select">
                <select name="time" id="time">
                    @foreach ($times as $time)
                    <option value="{{ $time }}" {{ old('time')==$time ? 'selected' : '' }}>
                        {{ $time }}
                    </option>
                    @endforeach
                </select>
                @error('time')
                <div class="reservation-form__error">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="reservation-form__select">
                <select name="number" id="number">
                    @for ($i = 1; $i <= 20; $i++) <option value="{{ $i }}" {{ old('number')=="$i" ? 'selected' : '' }}>
                        {{ $i }}人
                        </option>
                        @endfor
                </select>
                @error('number')
                <div class="reservation-form__error">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="reservation-data">
                <table class="reservation-data__table">
                    <tr class="reservation-data__table--inner">
                        <th class="reservation-data__table--header">Shop</th>
                        <td class="reservation-data__table--text">
                            <p class="reservation-data__table--text-shop">{{ $shop->shop_name }}</p>
                        </td>
                    </tr>
                    <tr class="reservation-data__table--inner">
                        <th class="reservation-data__table--header">Date</th>
                        <td class="reservation-data__table--text">
                            <p class="reservation-data__table--text-date"></p>
                        </td>
                    </tr>
                    <tr class="reservation-data__table--inner">
                        <th class="reservation-data__table--header">Time</th>
                        <td class="reservation-data__table--text">
                            <p class="reservation-data__table--text-time"></p>
                        </td>
                    </tr>
                    <tr class="reservation-data__table--inner">
                        <th class="reservation-data__table--header">Number</th>
                        <td class="reservation-data__table--text">
                            <p class="reservation-data__table--text-number"></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="reservation-form__btn">
            <button class="reservation-form__btn--submit" type="submit">予約する</button>
        </div>
    </form>
    @endif
</div>
<script src="/js/reservation.js" defer></script>
@endsection
