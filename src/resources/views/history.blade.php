@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/history.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
@php
use Carbon\Carbon;
@endphp
<div class="history__grid-parent">
    <div class="history__login-name">{{$user->name}}さん</div>
    <div class="history">
        <div class="history__ttl">
            <a class="history__ttl--link" href="{{ route('mypage') }}"><i class="bi bi-chevron-left"></i></a>
            <span>来店履歴</span>
        </div>
        @if ($reservations->isEmpty())
        <div class="history__ttl--empty-message">
            <p>来店済みの店舗はありません。</p>
        </div>
        @else
        <div class="flash-message">
            @if (session('flash-message'))
            {{ session('flash-message') }}
            @endif
        </div>
        <div class="history__detail--grid-parent">
            @foreach ($reservations as $index => $reservation)
            <div class="history__detail">
                <div class="history__detail--header flex justify-between">
                    <p class="history__detail--header-ttl">来店 {{ $index + 1 }}</p>
                    <div class="history__detail--modal">
                        @if (!empty($reservation->rank))
                        <span class="history__detail--checked"><i class="bi bi-check-lg"></i></span>
                        @endif
                        <label for="modal-toggle-{{$reservation->id}}" class="history__modal--button-label"><i
                                class="bi bi-chat-left-heart-fill"></i></label>
                        <input type="checkbox" id="modal-toggle-{{$reservation->id}}" class="modal-toggle">
                        <div class="modal">
                            <form class="history__modal--form" action="{{route('rank')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$reservation->id}}">
                                <table class="history__modal--table">
                                    <tr class="history__modal--table-inner">
                                        <th class="history__modal--table-header">Shop</th>
                                        <td class="history__modal--table-text">
                                            <p class="history__modal--table-text-shop">{{
                                                $reservation->shop->shop_name }}</p>
                                        </td>
                                    </tr>
                                    <tr class="history__modal--table-inner">
                                        <th class="history__modal--table-header"><label for="rank">評価</label>
                                        </th>
                                        <td class="history__modal--table-text">
                                            <select class="history__modal--table-select" name="rank" id="rank">
                                                <option value="5" <?php if ($reservation->rank==5) echo 'selected' ;
                                                    ?>>★★★★★
                                                </option>
                                                <option value="4" <?php if ($reservation->rank==4) echo 'selected' ;
                                                    ?>>★★★★☆
                                                </option>
                                                <option value="3" <?php if ($reservation->rank==3) echo 'selected' ;
                                                    ?>>★★★☆☆
                                                </option>
                                                <option value="2" <?php if ($reservation->rank==2) echo 'selected' ;
                                                    ?>>★★☆☆☆
                                                </option>
                                                <option value="1" <?php if ($reservation->rank==1) echo 'selected' ;
                                                    ?>>★☆☆☆☆
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="history__modal--table-inner">
                                        <td class="history__modal--table-text" colspan="2">
                                            <textarea class="history__modal--table-textarea" name="comment" id="comment"
                                                cols="10" rows="8" placeholder="コメント頂けると嬉しいです。
                                            必須ではありません。
                                            ">{{ $reservation->comment }}</textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div class="history__modal--button">
                                    <label class="history__modal--button-close"
                                        for="modal-toggle-{{$reservation->id}}"><i class="bi bi-reply-fill"></i></label>
                                    <button class="history__modal--button-submit" type="submit">送信</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="history__list">
                    <table class="history__table">
                        <tr class="history__table--inner">
                            <th class="history__table--header">Shop</th>
                            <td class="history__table--text">
                                <p class="history__table--text-shop">{{ $reservation->shop->shop_name }}</p>
                            </td>
                        </tr>
                        <tr class="history__table--inner">
                            <th class="history__table--header">Date</th>
                            <td class="history__table--text">
                                <p class="history__table--text-date">{{ $reservation->date }}</p>
                            </td>
                        </tr>
                        <tr class="history__table--inner">
                            <th class="history__table--header">Time</th>
                            <td class="history__table--text">
                                <p class="history__table--text-time">{{
                                    Carbon::parse($reservation->time)->format('H:i') }}</p>
                            </td>
                        </tr>
                        <tr class="history__table--inner">
                            <th class="history__table--header">Number</th>
                            <td class="history__table--text">
                                <p class="history__table--text-number">{{ $reservation->number }}人</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
