@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/history.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_owner')
@endcomponent
@endif
@php
use Carbon\Carbon;
@endphp
<div class="content">
    <div class="shopDetail">
        <div class="shopDetail__ttl">
            <a class="shopDetail__ttl--link" href="{{route('owner')}}"><i class="bi bi-chevron-left"></i></a>
            <h2 class="shopDetail__ttl--h2">{{ $shop->shop_name }}</h2>
        </div>
        <div class="shopDetail__img">
            <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="600" height="400">
        </div>
        <div class="shopDetail__tag">
            <p class="shopDetail__tag--p">#{{ $shop->areas->name }} #{{ $shop->genres->name }}</p>
        </div>
        <div class="shopDetail__overview">
            <p class="shopDetail__overview--p">{{ $shop->overview }}</p>
        </div>
    </div>
    <div class="reservationDetail">
        <div class="reservationDetail__ttl">
            <span>予約状況</span>
            <span class="reservationDetail__ttl--link">過去履歴は<a
                    href="{{ route('reservationPastHistory', $shop->id) }}">コチラ</a></span>
        </div>
        @if ($reservations->isEmpty())
        <div class="reservationDetail__ttl--empty-message">
            <p>予約済みの店舗はありません。</p>
        </div>
        @else
        <div class="reservationDetail__grid">
            @foreach ($reservations as $index => $reservation)
            <div class="reservationDetail__card">
                <div class="reservationDetail__card--header">
                    <span class="reservationDetail__card--header-ttl">予約 {{ $index + 1 }}</span>
                    <span class="reservationDetail__card--header-name">{{ $reservation->users->name }}さん</span>
                </div>
                <table class="reservationDetail__card--table">
                    <tr class="reservationDetail__card--table--inner">
                        <th class="reservationDetail__card--table--header">Date</th>
                        <td class="reservationDetail__card--table--text">
                            <p class="reservationDetail__card--table--text-date">{{ $reservation->date }}</p>
                        </td>
                    </tr>
                    <tr class="reservationDetail__card--table--inner">
                        <th class="reservationDetail__card--table--header">Time</th>
                        <td class="reservationDetail__card--table--text">
                            <p class="reservationDetail__card--table--text-time">{{
                                Carbon::parse($reservation->time)->format('H:i') }}</p>
                        </td>
                    </tr>
                    <tr class="reservationDetail__card--table--inner">
                        <th class="reservationDetail__card--table--header">Number</th>
                        <td class="reservationDetail__card--table--text">
                            <p class="reservationDetail__card--table--text-number">{{ $reservation->number }}人</p>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
