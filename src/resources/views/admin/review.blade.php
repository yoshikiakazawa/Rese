@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/review.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_admin')
@endcomponent
<div class="review-detail">
    <div class="review-ttl flex">
        <a class="review-ttl__link" href="{{ route('admin') }}"><i class="bi bi-chevron-left"></i></a>
        <textarea class="review-ttl__shop-name" rows="2" readonly>{{ $shop->shop_name }}</textarea>
    </div>

    @if (empty($reviews[0]))
    <p>レビューがありません。</p>
    @else
    <h2 class="review-detail__ttl">全ての口コミ情報</h2>
    <div class="flash-message">
        @if(session('flash-message'))
        {{ session('flash-message') }}
        @endif
    </div>

    @foreach ($reviews as $review)
    <div class="review-detail__cards">
        @if (!empty($review->image))
        <img class="review-detail__image" src="{{ $review->image }}" alt="{{ $review->shop->name }}" width="120"
            height="60">
        @endif
        <div class="flex justify-between align-items-center">
            <div class="review-detail__stars">
                @for ($i = 1; $i <= 5; $i++) <span class="{{ $i <= $review->rank ? 'star-blue' : 'star' }}">★</span>
                    @endfor
            </div>
            <form onsubmit="return confirm('本当に削除しますか？')" action="{{ route('adminReviewDestroy') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $review->id }}">
                <button class="review-detail__delete-btn" type="submit">口コミを削除</button>
            </form>
        </div>
        <textarea class="review-detail__comment" name="comment" readonly>{{ $review->comment }}</textarea>
    </div>
    @endforeach
    @endif
</div>

@endif
@endsection
