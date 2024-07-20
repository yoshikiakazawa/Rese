@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/past-history.css') }}">
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
    <div class="pastHistory">
        <div class="pastHistory__ttl">
            <a class="pastHistory__ttl--link" href="{{route('reservationHistory', $shop->id)}}"><i
                    class="bi bi-chevron-left"></i></a>
            <h2 class="pastHistory__ttl--h2">{{ $shop->shop_name }}</h2>
        </div>
        <div class="pastHistoryDetail">
            <div class="pastHistoryDetail__ttl">
                <span>過去履歴</span>
            </div>
            @if ($reservations->isEmpty())
            <div class="pastHistoryDetail__ttl--empty-message">
                <p>予約済みの店舗はありません。</p>
            </div>
            @else
            <div class="pastHistoryDetail__grid">
                @foreach ($reservations as $index => $reservation)
                <div class="pastHistoryDetail__card">
                    <div class="pastHistoryDetail__card--header">
                        <span class="pastHistoryDetail__card--header-ttl">予約 {{ $index + 1 }}</span>
                        <span class="pastHistoryDetail__card--header-name">{{ $reservation->users->name }}さん</span>
                    </div>
                    <div class="pastHistoryDetail__card--group">
                        <label class="pastHistoryDetail__card--group-header">Date</label>
                        <p class="pastHistoryDetail__card--group-text">{{ $reservation->date }}</p>
                    </div>
                    <div class="pastHistoryDetail__card--group">
                        <label class="pastHistoryDetail__card--group-header">Time</label>
                        <p class="pastHistoryDetail__card--group-text">{{
                            Carbon::parse($reservation->time)->format('H:i') }}</p>
                    </div>
                    <div class="pastHistoryDetail__card--group">
                        <label class="pastHistoryDetail__card--group-header">Number</label>
                        <p class="pastHistoryDetail__card--group-text">{{ $reservation->number }}人</p>
                    </div>
                    <div class="pastHistoryDetail__card--group">
                        <label class="pastHistoryDetail__card--group-header">rank</label>
                        <p class="pastHistoryDetail__card--group-text">
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
                    <div class="pastHistoryDetail__card--group-comment">
                        <label class="pastHistoryDetail__card--group-comment-header">comment</label>
                        <p class="pastHistoryDetail__card--group-comment-text">
                            {{ $reservation->comment }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
