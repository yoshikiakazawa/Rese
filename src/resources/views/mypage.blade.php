@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav')
@endcomponent
@endif
@php
use Carbon\Carbon;
@endphp
<div class="mypage__grid-parent">
    <div class="mypage__login-name">{{$user->name}}さん</div>
    <div class="reservation-status">
        <div class="reservation-status__ttl">
            <span>予約状況</span>
            <span class="reservation-status__ttl--link">訪問履歴は<a href="{{ route('history') }}">コチラ</a></span>
        </div>
        @if ($reservations->isEmpty())
        <div class="reservation-status__ttl--empty-message">
            <p>予約済みの店舗はありません。</p>
        </div>
        @else
        <div class="flash_message">
            @if (session('message_reservation'))
            {{ session('message_reservation') }}
            @endif
        </div>
        @foreach ($reservations as $index => $reservation)
        <div class="reservation-status__detail">
            <div class="reservation-status__detail--header">
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
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-shop">{{ $reservation->shops->shop_name }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Date</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-date">{{ $reservation->date }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Time</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-time">{{
                            Carbon::parse($reservation->time)->format('H:i') }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Number</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-number">{{ $reservation->number }}人</p>
                    </td>
                </tr>
            </table>
            <div class="reservation-status__qr">
                <label for="qr-modal__toggle-{{$reservation->id}}" class="qr-modal__button--open">チェックイン</label>
                <input type="checkbox" id="qr-modal__toggle-{{$reservation->id}}" class="qr-modal__toggle">
                <div class="qr-modal">
                    <label for="qr-modal__toggle-{{$reservation->id}}" class="qr-modal__button--close"><i
                            class="bi bi-x-circle"></i></label>
                    <span class="qr-modal__span">
                        {!! QrCode::size(100)->generate( $reservation->id ); !!}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="favorite-shop__detail">
        <div class="favorite-shop__ttl">お気に入り店舗</div>
        @if ($favoriteShops->isEmpty())
        <div class="favorite-shop__ttl--empty-message">
            <p>お気に入りに登録された店舗はありません。</p>
        </div>
        @else
        <div class="flash_message">
            @if (session('message_favorite'))
            {{ session('message_favorite') }}
            @endif
        </div>
        <div class="favorite-shop__list">
            <div class="favorite-shop__list--grid-parent">
                @foreach ($favoriteShops as $favoriteShop)
                <div class="favorite-shop__card">
                    <div class="favorite-shop__card--img">
                        <img src="{{ $favoriteShop->image_path }}" alt="{{ $favoriteShop->shop_name }}">
                    </div>
                    <div class="favorite-shop__card--article">
                        <div class="favorite-shop__card--ttl">
                            <h2 class="favorite-shop__card--ttl-h2">{{ $favoriteShop->shop_name }}</h2>
                        </div>
                        <div class="tag">
                            <p class="favorite-shop__card--tag">#{{ $favoriteShop->areas->name }}
                                #{{$favoriteShop->genres->name }}</p>
                        </div>
                        <div class="favorite-shop__card--button">
                            <a class="favorite-shop__card--button--link"
                                href="{{ route('detail', $favoriteShop->id) }}">詳しくみる</a>
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
        @endif
    </div>
</div>
<script src="/js/heart.js"></script>
@endsection
