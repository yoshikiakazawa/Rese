@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
@php
use Carbon\Carbon;
@endphp
<div class="mypage__login-name">{{$user->name}}さん</div>
<div class="flex container">
    <div class="reservation-status">
        <div class="flex justify-center align-items-center reservation-status__ttl">
            <p>予約状況</p>
            <p class="reservation-status__ttl--link">訪問履歴は<a href="{{ route('history') }}">コチラ</a></p>
        </div>
        <div class="flash-message">
            @if ($reservations->isEmpty())
            <p>予約済みの店舗はありません</p>
            @endif
            @if(session('message_reservation'))
            {{ session('message_reservation') }}
            @endif
        </div>
        @foreach ($reservations as $index => $reservation)
        <div class="reservation-status__detail">
            <div class="flex justify-between align-items-center reservation-status__detail--header">
                <a class="reservation-status__detail--header-update-button"
                    href="{{ route('editReservation', $reservation->id) }}"><i class="bi bi-pencil-square"></i></a>
                <p class="reservation-status__detail--header-ttl">予約 {{ $index + 1 }}</p>
                <form onsubmit="return confirm('本当に削除しますか？')" action="{{route('destroyReservation')}}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" value="{{$reservation->id}}">
                    <button class="reservation-status__detail--header-delete-button-submit" type="submit"><i
                            class="bi bi-eraser-fill"></i></button>
                </form>
            </div>
            <table class="reservation-status__table">
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Shop</th>
                    <td>
                        <p class="reservation-status__table--text">{{ $reservation->shop->shop_name }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Date</th>
                    <td>
                        <p class="reservation-status__table--text">{{ $reservation->date }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Time</th>
                    <td>
                        <p class="reservation-status__table--text">{{
                            Carbon::parse($reservation->time)->format('H:i') }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Number</th>
                    <td>
                        <p class="reservation-status__table--text">{{ $reservation->number }}人</p>
                    </td>
                </tr>
            </table>
            <div class="reservation-status__modal">
                <label for="statusModal__toggle-{{$reservation->id}}"
                    class="statusModal__button--open">チェックイン/決済</label>
                <input type="checkbox" id="statusModal__toggle-{{$reservation->id}}" class="statusModal__toggle">
                <div class="statusModal">
                    <label for="statusModal__toggle-{{$reservation->id}}" class="statusModal__button--close"><i
                            class="bi bi-x-circle"></i></label>
                    <span class="statusModal__qr">
                        {!! QrCode::size(100)->generate( $reservation->id ); !!}
                    </span>
                    @if(empty($reservation->payment_status) || $reservation->payment_status === 0)
                    <form class="statusModal__pay" action="{{ route('pay') }}" method="POST">
                        @csrf
                        <div class="statusModal__pay--amountGroup">
                            <label>支払金額</label>
                            <p>￥{{ $reservation->amount }}</p>
                            <input type="hidden" name="id" value="{{ $reservation->id }}">
                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ env('STRIPE_KEY') }}" data-name="Stripe Demo" data-label="決済"
                                data-description="Online course about integrating Stripe"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto" data-currency="JPY">
                            </script>
                        </div>
                    </form>
                    @else
                    <p class="statusModal__pay--text">支払済みです</p>
                    @endif
                </div>
            </div>
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
    <div class="favorite-shop__detail">
        <div class="favorite-shop__ttl">お気に入り店舗</div>
        <div class="flash-message">
            @if ($favoriteShops->isEmpty())
            <p>お気に入りに登録された店舗はありません</p>
            @endif
        </div>
        <div class="flex align-items-center wrap">
            @foreach ($favoriteShops as $favoriteShop)
            <div class="favorite-shop__card">
                <img class="favorite-shop__card--img" src="{{ $favoriteShop->image_path }}"
                    alt="{{ $favoriteShop->shop_name }}">
                <div class="favorite-shop__card--article">
                    <textarea class="favorite-shop__card--shop-name" rows="2" readonly>{{ $favoriteShop->shop_name }}</textarea>
                    <div class="tag">
                        <p class="favorite-shop__card--tag">#{{ $favoriteShop->area->name }}
                            #{{$favoriteShop->genre->name }}</p>
                    </div>
                    <div class="flex justify-between align-items-center">
                        <a class="favorite-shop__detail-btn" href="{{ route('detail', $favoriteShop->id) }}">詳しくみる</a>
                        @php
                        $isFavorite = in_array($favoriteShop->id, $favorites);
                        @endphp
                        <div class="heart {{ $isFavorite ? 'heart_true' : 'heart_false' }}"
                            data-shop-id="{{ $favoriteShop->id }}"><i class="bi bi-suit-heart-fill" id="heart"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="/js/heart.js"></script>
@endsection
