@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_admin')
@endcomponent
<div class="owner-list">
    <div class="owner-list__heading">
        <h2>OwnerList</h2>
    </div>
    <div class="owner-list__table">
        <table class="owner-list__table--inner">
            <tr class="owner-list__table--row">
                <th class="owner-list__table--header">ID</th>
                <th class="owner-list__table--header">お名前</th>
                <th class="owner-list__table--header">List</th>
            </tr>
            @foreach ($owners as $owner)
            <tr class="owner-list__table--row">
                <th class="owner-list__table--content">{{ $owner->login_owner_id }}</th>
                <th class="owner-list__table--content">{{ $owner->name }}</th>
                <th class="owner-list__table--content">
                    <a class="owner-list__table--button-link" href="{{ route('detailOwner', $owner->id) }}">一覧</a>
                </th>
            </tr>
            @endforeach
        </table>
    </div>

    <form class="owner-list__form" action="{{ route('storeOwner') }}" method="post">
        @csrf
        <div class="owner-list__form--ttl">
            <h2>新規登録</h2>
            <div class="flash_message">
                @if (session('message'))
                {{ session('message') }}
                @endif
            </div>
        </div>
        <div class="owner-list__form--text-group">
            <div class="owner-list__form--input">
                <img src="{{ asset('/images/user.png') }}">
                <input type="text" placeholder="name" name="name" value="{{ old('name') }}">
            </div>
            <div class="owner-list__form__message">
                <p>空白ok</p>
            </div>
        </div>
        <div class="owner-list__form--text-group">
            <div class="owner-list__form--input">
                <img src="{{ asset('/images/user.png') }}">
                <input type="text" placeholder="ID" name="login_owner_id" value="{{ old('login_owner_id') }}">
            </div>
            <div class="owner-list__form__error-message">
                @error('login_owner_id')
                <p>{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="owner-list__form--text-group">
            <div class="owner-list__form--input">
                <img src="{{ asset('/images/password.png') }}">
                <input type="password" placeholder="Password" name="password">
            </div>
            <div class="owner-list__form__error-message">
                @error('password')
                <p>{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="owner-list__form__btn">
            <button class="owner-list__form__btn--submit" type="submit">登録</button>
        </div>
    </form>
</div>
@endif
@endsection
