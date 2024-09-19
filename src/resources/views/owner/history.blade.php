@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/history.css') }}">
@endsection

@section('main')
@component('components.nav_owner')
@endcomponent

@php
use Carbon\Carbon;
@endphp
<div class="reservation-history">
    <div class="reservation-history__shop-name flex align-items-center">
        <a class="reservation-history__back-link" href="{{route('owner')}}"><i class="bi bi-chevron-left"></i></a>
        <h2>{{ $shop->shop_name }}</h2>
    </div>
    <h3 class="reservation-history__ttl">予約状況</h3>
    <span>過去履歴は</span>
    <a class="reservation-history__ttl--link" href="{{ route('reservationPastHistory', $shop->id) }}">コチラ</a>
    @if ($reservations->isEmpty())
    <div class="historyDetail__ttl--empty-message">
        <p>予約済みの店舗はありません。</p>
    </div>
    @else
    <div class="flex align-items-center wrap">
        @foreach ($reservations as $index => $reservation)
        <div class="historyDetail__card">
            <div class="historyDetail__card--header flex justify-between align-items-center">
                <span>予約 {{ $index + 1 }}</span>
                <span>{{ $reservation->user->name }}さん</span>
            </div>
            <div class="flex align-items-center">
                <label class="historyDetail__card-label">Date</label>
                <span class="historyDetail__card-text">{{ $reservation->date }}</span>
            </div>
            <div class="flex align-items-center">
                <label class="historyDetail__card-label">Time</label>
                <span class="historyDetail__card-text">{{
                    Carbon::parse($reservation->time)->format('H:i') }}</span>
            </div>
            <div class="flex align-items-center">
                <label class="historyDetail__card-label">Number</label>
                <span class="historyDetail__card-text">{{ $reservation->number }}人</span>
            </div>
            <form class="historyDetail__card--form" action="{{ route('amount') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $reservation->id }}">
                <div class="flex justify-between align-items-center">
                    <div class="flex align-items-center historyDetail__card--form-status">
                        <label class="historyDetail__card-label-status">支払状況:</label>
                        <span class="historyDetail__card-text-status">
                            @if(empty($reservation->payment_status) || $reservation->payment_status === 0)
                            未払い
                            @else
                            支払済み
                            @endif
                        </span>
                    </div>
                    <button class="historyDetail__card--btn" type="submit">金額確定</button>
                </div>
                <div class="flex justify-between align-items-center">
                    <label class="historyDetail__card-label" for="amount">請求金額</label>
                    <input class="historyDetail__card-input" type="text" name="amount" id="amount"
                        value="{{ $reservation->amount }}" required>
                    <span>円</span>
                </div>
            </form>
            @if (session('flash-message'))
            <script>
                window.onload = function() {
                    alert('{{ session('flash-message') }}');
                }
            </script>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
