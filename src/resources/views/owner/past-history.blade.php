@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/past-history.css') }}">
@endsection

@section('main')
@component('components.nav_owner')
@endcomponent
@php
use Carbon\Carbon;
@endphp
<div class="pastHistory">
    <div class="pastHistory__ttl flex align-items-center">
        <a class="pastHistory__ttl--link" href="{{route('reservationHistory', $shop->id)}}"><i
                class="bi bi-chevron-left"></i></a>
        <h2 class="pastHistory__ttl--shop-name">{{ $shop->shop_name }}</h2>
    </div>
    <div class="pastHistoryDetail">
        <h2 class="pastHistoryDetail__ttl">過去履歴</h2>
        @if ($reservations->isEmpty())
        <div class="flash-message">
            <span>&lt;予約履歴はありません&gt;</span>
        </div>
        @else
        <div class="flex aligun-items-center wrap">
            @foreach ($reservations as $index => $reservation)
            <div class="pastHistoryDetail__card">
                <div class="pastHistoryDetail__card--ttl flex justify-between align-items-center">
                    <span>予約 {{ $index + 1 }}</span>
                    <span>{{ $reservation->user->name }}さん</span>
                </div>
                <div class="flex align-items-center">
                    <label class="pastHistoryDetail__card--label">Date</label>
                    <p class="pastHistoryDetail__card--text">{{ $reservation->date }}</p>
                </div>
                <div class="flex align-items-center">
                    <label class="pastHistoryDetail__card--label">Time</label>
                    <p class="pastHistoryDetail__card--text">{{
                        Carbon::parse($reservation->time)->format('H:i') }}</p>
                </div>
                <div class="flex align-items-center">
                    <label class="pastHistoryDetail__card--label">Number</label>
                    <p class="pastHistoryDetail__card--text">{{ $reservation->number }}人</p>
                </div>
                <div class="flex align-items-center">
                    <label class="pastHistoryDetail__card--label">rank</label>
                    <p class="pastHistoryDetail__card--text">
                        @for ($i = 0; $i < 5; $i++) @if ($i < $reservation->rank - 0.5)
                            ★
                            @elseif ($i < $reservation->rank)
                                ☆
                                @else
                                ☆
                                @endif
                                @endfor
                    </p>
                </div>
                <label class="pastHistoryDetail__card--comment-label">comment</label>
                <textarea class="pastHistoryDetail__card--comment" readonly>
                        {{ $reservation->comment }}
                    </textarea>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
