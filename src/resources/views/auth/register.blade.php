@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
<div class="auth">
    <div class="auth-parent">
        <form class="auth-form" action="{{ route('register') }}" method="post">
            @csrf
            <div class="auth-ttl">
                <h2>Registration</h2>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--text">
                    <img src="{{ asset('/images/user.png') }}">
                    <input type="name" placeholder="Username" name="name" value="{{ old('name') }}">
                </div>
                <div class="error-message">
                    @error('name')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--text">
                    <img src="{{ asset('/images/mail.png') }}">
                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                </div>
                <div class="error-message">
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--text">
                    <img src="{{ asset('/images/password.png') }}">
                    <input type="password" placeholder="Password" name="password">
                </div>
                <div class="error-message">
                    @error('password')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--btn">
                    <button class="auth-form__content--btn-submit" type="submit">登録</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
