@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/detail.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_admin')
@endcomponent
<div class="owner-detail">
    <div class="owner-detail__ttl">
        <div class="flex align-items-center">
            <a class="owner-detail__ttl--back-link" href="{{ route('admin') }}"><i class="bi bi-chevron-left"></i></a>
            <h2 class="owner-detail__ttl--header">Owner Detail</h2>
        </div>
        <span class="owner-detail__user-date-id">ID:{{ $owner->login_owner_id }}</span>
        <span class="owner-detail__user-date-name">name:{{ $owner->name }}</span>
    </div>
    <div class="owner-detail__cards">
        @foreach ($shops as $shop)
        <div class="card-content">
            <img class="card-content__img" src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300"
                height="200">
            <h2 class="card-content__ttl">{{ $shop->shop_name }}</h2>
            <p class="card-content__tag">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
            <textarea class="card-content__overview"> {{ $shop->overview }}</textarea>
        </div>
        @endforeach
    </div>
</div>
<div class="create-shop-form flex">
    <form class="csv-form" action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="owner_id" value="{{ $owner->id }}">
        <h2 class="csv-form__ttl">Shop登録 &lt;CSV SubmissionForm&gt;</h2>
        <div class="flex align-items-center justify-center">
            <div class="csv-form__drop-area">
                <label class="csv-form__drop-area-label" for="csvFile">クリック<br>または<br>ドラッグアンドドロップ</label>
                <input class="csv-form__input" type="file" name="csvFile" id="csvFile">
            </div>
            <button class="csv-form__btn flex justify-center align-items-center" type="submit">送信</button>
        </div>
    </form>
    <div class="message-field">
        <div class="flash-message">
            @if (session('flash-message'))
            {{ session('flash-message') }}
            @endif
        </div>
        @if (count($errors) > 0)
        <div class="error-message">
            @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif
@endsection
