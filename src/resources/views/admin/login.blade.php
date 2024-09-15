@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
@component('components.nav_admin')
@endcomponent
<div class="auth">
    <div class="auth-parent">
        <form class="auth-form" action="{{ route('adminLogin') }}" method="post">
            @csrf
            <div class="auth-ttl">
                <h2>Admin Login</h2>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--text">
                    <img src="{{ asset('/images/mail.png') }}">
                    <input type="text" placeholder="Admin ID" name="login_admin_id" value="{{ old('login_admin_id') }}">
                </div>
                <div class="auth-form__content--error">
                    @error('login_admin_id')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--text">
                    <img src="{{ asset('/images/password.png') }}">
                    <input type="password" placeholder="Password" name="password">
                </div>
                <div class="auth-form__content--error">
                    @error('password')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="auth-form__content">
                <div class="auth-form__content--btn">
                    <button class="auth-form__content--btn-submit" type="submit">ログイン</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
