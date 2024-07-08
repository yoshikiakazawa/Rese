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
        <div class="owner-detail__ttl--header">
            <a class="owner-detail__ttl--header-link" href="{{ route('admin') }}"><i
                    class="bi bi-chevron-left"></i></a>
            <h2 class="owner-detail__ttl--header-h2">Owner Detail</h2>
        </div>
        <div class="owner-detail__ttl--table">
            <table class="owner-detail__ttl--table-inner">
                <tr class="owner-detail__ttl--table-row">
                    <th rowspan="2" class="owner-detail__ttl--table-header"></th>
                    <th class="owner-detail__ttl--table-header">ID</th>
                    <th class="owner-detail__ttl--table-header">お名前</th>
                </tr>
                <tr class="owner-detail__ttl--table-row">
                    <th class="owner-detail__ttl--table-content">{{ $owner->ownerid }}</th>
                    <th class="owner-detail__ttl--table-content">{{ $owner->name }}</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="card">
        @foreach ($shops as $shop)
        <div class="card-content">
            <div class="card-content__img">
                <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300" height="200">
            </div>
            <div class="card-content__ttl">
                <h2>{{ $shop->shop_name }}</h2>
            </div>
            <div class="card-content__tag">
                <p>#{{ $shop->areas->name }} #{{ $shop->genres->name }}</p>
            </div>
            <div class="card-content__overview">
                <p>{{ $shop->overview }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
