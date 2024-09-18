@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
<div class="review-container">
    <div class="flash-message">
        @if(session('flash-message'))
        {{ session('flash-message') }}
        @endif
    </div>
    <div class="flex center wrap-768px">
        <div class="review-container__left">
            <p class="review-container__message">今回のご利用はいかかでしたか？</p>
            <div class="review-container__card">
                <img class="review-container__card--image" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}"
                    width="100%" height="150">
                <p class="review-container__card--name">{{ $shop->shop_name }}</p>
                <p class="review-container__card--tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
                <div class=" flex justify-between review-container__card--btn">

                    <div class="modal">
                        <label for="review-container__modal-toggle-{{$shop->id}}"
                            class="review-container__modal-btn-open">詳しく見る</label>
                        <input type="checkbox" id="review-container__modal-toggle-{{$shop->id}}"
                            class="review-container__modal-toggle">
                        <div class="review-container__modal">
                            <div class="flex align-items-center justify-between">
                                <span>概要</span>
                                <label for="review-container__modal-toggle-{{$shop->id}}"
                                    class="review-container__modal-btn-close"><i class="bi bi-x-circle"></i></label>
                            </div>
                            <p class="review-container__modal-txt">
                                {{ $shop->overview }}
                            </p>
                        </div>
                    </div>

                    @if($favorite->isEmpty())
                    <div class="heart_false" data-shop-id="{{ $shop->id }}">
                        <i class="bi bi-suit-heart-fill" id="heart"></i>
                    </div>
                    @else
                    <div class="heart_true" data-shop-id="{{ $shop->id }}">
                        <i class="bi bi-suit-heart-fill" id="heart"></i>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="review-container__right">
            <form action="{{ route('storeReview', $shop->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <label class="review-container__label" for="rank">体験を評価してください</label>
                <div class="error-message">
                    @error('rank')
                    {{$message}}
                    @enderror
                </div>
                <div class="stars" data-rating="{{ $review->rank ?? 0 }}">
                    <span class="star" data-value="1">★</span>
                    <span class="star" data-value="2">★</span>
                    <span class="star" data-value="3">★</span>
                    <span class="star" data-value="4">★</span>
                    <span class="star" data-value="5">★</span>
                </div>
                <input type="hidden" name="rank" id="rank" value="{{ $review->rank ?? 0 }}">
                <div class="review-container__form-comment">
                    <label class="review-container__label" for="comment">口コミを投稿</label>
                    <div class="error-message">
                        @error('comment')
                        {{$message}}
                        @enderror
                    </div>
                    <textarea class="review-container__text" name="comment" id="comment"
                        placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('comment', $review->comment ?? '') }}</textarea>
                    <span class="review-container__text-comment">0/400(最高文字数)</span>
                </div>
                <div class="flex justify-between review-container__image-box">
                    <label class="review-container__label" for="">画像の追加</label>
                    <img class="image-preview" src="" alt="" width="100" id="imagePreview">
                </div>
                <div class="error-message">
                    @error('image')
                    {{$message}}
                    @enderror
                </div>
                <div class="drop-area">
                    <label class="drop-area__label-top" for="image">クリックして写真を追加</label>
                    <label class="drop-area__label-bottom" for="image">またはドラッグアンドドロップ</label>
                    <input class="review-container__image" type="file" name="image" id="image"
                        onchange="previewImage(event)">
                </div>
                <button class="review-container__form-btn" type="submit">口コミを投稿</button>
            </form>
        </div>
    </div>
</div>
<script src="/js/heart.js" defer></script>
<script src="/js/review.js" defer></script>
@endsection
