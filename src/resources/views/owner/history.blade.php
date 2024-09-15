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
<div class="content">
    <div class="shopDetail">
        <div class="shopDetail__ttl">
            <a class="shopDetail__ttl--link" href="{{route('owner')}}"><i class="bi bi-chevron-left"></i></a>
            <h2 class="shopDetail__ttl--h2">{{ $shop->shop_name }}</h2>
        </div>
        <div class="shopDetail__card">
            <div class="shopDetail__img">
                <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="600" height="400">
            </div>
            <div class="shopDetail__tag">
                <p class="shopDetail__tag--p">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
            </div>
            <div class="shopDetail__overview">
                <p class="shopDetail__overview--p">{{ $shop->overview }}</p>
            </div>
        </div>
    </div>
    <div class="historyDetail">
        <div class="historyDetail__ttl">
            <span>予約状況</span>
            <span class="historyDetail__ttl--link">過去履歴は<a
                    href="{{ route('reservationPastHistory', $shop->id) }}">コチラ</a></span>
        </div>
        @if ($reservations->isEmpty())
        <div class="historyDetail__ttl--empty-message">
            <p>予約済みの店舗はありません。</p>
        </div>
        @else
        <div class="historyDetail__grid">
            @foreach ($reservations as $index => $reservation)
            <div class="historyDetail__card">
                <div class="historyDetail__card--header">
                    <span class="historyDetail__card--header-ttl">予約 {{ $index + 1 }}</span>
                    <span class="historyDetail__card--header-name">{{ $reservation->user->name }}さん</span>
                </div>
                <div class="historyDetail__card--group">
                    <label class="historyDetail__card--group-header">Date</label>
                    <p class="historyDetail__card--group-text">{{ $reservation->date }}</p>
                </div>
                <div class="historyDetail__card--group">
                    <label class="historyDetail__card--group-header">Time</label>
                    <p class="historyDetail__card--group-text">{{
                        Carbon::parse($reservation->time)->format('H:i') }}</p>
                </div>
                <div class="historyDetail__card--group">
                    <label class="historyDetail__card--group-header">Number</label>
                    <p class="historyDetail__card--group-text">{{ $reservation->number }}人</p>
                </div>
                <form class="historyDetail__card--form" action="{{ route('amount') }}" method="post">
                    @csrf
                    <div class="historyDetail__card--group-status">
                        <label class="historyDetail__card--group-label-status">支払状況:</label>
                        <p class="historyDetail__card--group-text-status">
                            @if(empty($reservation->payment_status) || $reservation->payment_status === 0)
                            未払い
                            @else
                            支払済み
                            @endif
                        </p>
                    </div>
                    <div class="historyDetail__card--group-amount">
                        <label for="amount" class="historyDetail__card--group-label">請求金額</label>
                        <input class="historyDetail__card--group-input" type="text" name="amount" id="amount"
                            value="{{ $reservation->amount }}" required>
                        <span>円</span>
                        <input type="hidden" name="id" value="{{ $reservation->id }}">
                        <button class="historyDetail__card--btn" type="submit">確定</button>
                    </div>
                </form>
                @if (session('message'))
                <script>
                    window.onload = function() {
                    alert('{{ session('message') }}');
                }
                </script>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
