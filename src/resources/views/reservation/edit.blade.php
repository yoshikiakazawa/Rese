@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/reservation-form.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
@if(Auth::check())
<div class="detail">
    <div class="flex align-items-center">
        <a class="detail__ttl--link" href="{{ route('mypage') }}"><i class="bi bi-chevron-left"></i></a>
        <h2 class="detail__ttl--h2">{{ $shop->shop_name }}</h2>
    </div>
    <img class="detail__img" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="100%">
    <p class="detail__tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
    <p class="detail__overview">{{ $shop->overview }}</p>
</div>
<form class="reservation-form" action="{{ route('updateReservation') }}" method="post">
    @method('PATCH')
    @csrf
    <input type="hidden" name="id" value="{{ $reservation->id }}">
    <div class="reservation-form__content">
        <h2 class="reservation-form__ttl">予約変更</h2>
        <div class="reservation-form__input">
            <input type="date" name="date" id="date" value="{{$reservation->date}}">
            @error('date')
            <div class="reservation-form__error">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="reservation-form__select">
            <select name="time" id="time">
                @foreach ($times as $time)
                <option value="{{ $time }}" {{ $formattedTime==$time ? 'selected' : '' }}>
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
                @for ($i = 1; $i <= 20; $i++) <option value="{{ $i }}" {{ $reservation->number ==
                    "$i" ? 'selected' : '' }}>
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
    <button class="reservation-form__submit-btn" type="submit">修正する</button>
</form>
<script src="/js/edit.js" defer></script>
@endif
@endsection
