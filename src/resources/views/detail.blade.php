@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
<div class="detail">
    <div class="detail__ttl flex">
        <a class="detail__ttl--link" href="{{ route('index') }}"><i class="bi bi-chevron-left"></i></a>
        <textarea class="detail__ttl--shop-name" rows="2" readonly>{{ $shop->shop_name }}</textarea>
    </div>
    <img class="detail__img" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="100%">
    <p class="detail__tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
    <textarea class="detail__overview" readonly>{{ $shop->overview }}</textarea>
    @if(Auth::check())
    <div class="flash-message">
        @if(session('flash-message'))
        {{ session('flash-message') }}
        @endif
    </div>

    {{-- レビューフォーム --}}
    <div class="review__ttl">
        @if (empty($myReview) && empty($otherReviews[0]))
        <a class="review__link-btn" href="{{ route('showReview', $shop->id) }}">口コミを投稿する</a>
        <p>レビューがありません。</p>
        @elseif (empty($myReview) && !empty($otherReviews[0]))
        <a class="review__link-btn" href="{{ route('showReview', $shop->id) }}">口コミを投稿する</a>
        <h3 class="review-detail__ttl">全ての口コミ情報</h3>
        @elseif (!empty($myReview) && !empty($otherReviews[0]))
        <h3 class="review-detail__ttl">全ての口コミ情報</h3>
        @endif
    </div>
    {{-- 自分のレビュー --}}
    @if (!empty($myReview))
    <div class="review-detail__form">
        <form class="review-detail__form-edit" action="{{ route('editReview', $myReview->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <button class="review-detail__edit-btn" type="submit">口コミを編集</button>
            <div class="review-detail__image">
                <label>写真を追加</label>
                @if (!empty($myReview->image))
                <img src="{{ $myReview->image }}" alt="{{ $myReview->shop->name }}" width="120" height="60"
                    id="imagePreview">
                @endif
                <input type="file" name="image" id="image" onchange="previewImage(event)">
            </div>
            @error('image')
            <div class="error-message">
                {{$message}}
            </div>
            @enderror
            <div class="review-detail__stars" data-rating="{{ $myReview->rank ?? 0 }}">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <input type="hidden" name="rank" id="rank" value="{{ $myReview->rank ?? 0 }}">
            @error('rank')
            <div class="error-message">
                {{$message}}
            </div>
            @enderror
            <textarea class="review-detail__comment" name="comment">{{ $myReview->comment }}</textarea>
            @error('comment')
            <div class="error-message">
                {{$message}}
            </div>
            @enderror
        </form>
        <form onsubmit="return confirm('本当に削除しますか？')" class="review-detail__form-delete"
            action="{{ route('deleteReview') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $myReview->id }}">
            <button class="review-detail__delete-btn" type="submit">口コミを削除</button>
        </form>
    </div>
    @endif

    {{-- 他のユーザーのレビュー --}}
    @if (!empty($otherReviews[0]))
    @foreach ($otherReviews as $otherReview)
    <div class="review-detail__cards">
        @if (!empty($otherReview->image))
        <img src="{{ $otherReview->image }}" alt="{{ $otherReview->shop->name }}" width="120" height="60">
        @endif
        <div class="review-detail__stars pointer-none">
            @for ($i = 1; $i <= 5; $i++) <span class="{{ $i <= $otherReview->rank ? 'star-blue' : 'star' }}">★</span>
                @endfor
        </div>
        <textarea class="review-detail__comment" name="comment" readonly>{{ $otherReview->comment }}</textarea>
    </div>
    @endforeach
    @endif
</div>

{{-- 予約フォーム --}}
<form class="reservation-form" action="/done" method="post">
    @csrf
    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
    <div class="reservation-form__content">
        <h2 class="reservation-form__ttl">予約</h2>
        <div class="reservation-form__input">
            <input type="date" name="date" id="date">
            @error('date')
            <div class="error-message">
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
            <div class="error-message">
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
            <div class="error-message">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="reservation-data">
            <table class="reservation-data__table">
                <tr class="reservation-data__table--inner-shop-name flex align-items-center">
                    <th class="reservation-data__table--header">Shop</th>
                    <td class="reservation-data__table--text">
                        <p class="reservation-data__table--text-shop">{{ $shop->shop_name }}</p>
                    </td>
                </tr>
                <tr class="reservation-data__table--inner flex align-items-center">
                    <th class="reservation-data__table--header">Date</th>
                    <td class="reservation-data__table--text">
                        <p class="reservation-data__table--text-date"></p>
                    </td>
                </tr>
                <tr class="reservation-data__table--inner flex align-items-center">
                    <th class="reservation-data__table--header">Time</th>
                    <td class="reservation-data__table--text">
                        <p class="reservation-data__table--text-time"></p>
                    </td>
                </tr>
                <tr class="reservation-data__table--inner flex align-items-center">
                    <th class="reservation-data__table--header">Number</th>
                    <td class="reservation-data__table--text">
                        <p class="reservation-data__table--text-number"></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <button class="reservation-form__submit-btn" type="submit">予約する</button>
</form>
@endif
<script src="/js/reservation.js" defer></script>
<script src="/js/review.js" defer></script>
@endsection
