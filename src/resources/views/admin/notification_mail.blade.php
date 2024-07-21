@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/notification_mail.blade.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav_admin')
@endcomponent
<div class="sendMail__grid">
    <div class="sendMail">
        <h2 class="sendMail__ttl">お知らせmail作成</h2>
        <form class="sendMail__form" action="{{ route('admin.send-notification') }}" method="POST">
            @csrf
            <div class="sendMail__form--ttl">
                <label for="subject">件名</label>
                <input type="text" name="subject" id="subject" value="お知らせ">
            </div>
            <div class="sendMail__form--content">
                <div class="sendMail__form--content-flex">
                    <label for="message">本文</label>
                    <div class="sendMail__form--content-error-message">
                        @error('message')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <textarea name="message" id="message" rows="10" cols="30"></textarea>
            </div>
            <div class="sendMail__form--flex">
                <div class="sendMail__form--btn">
                    <button class="sendMail__form--btn-submit" type="submit">送信</button>
                </div>
                <div class="sendMail__form--message">
                    @if(session('message'))
                    <p>{{ session('message') }}</p>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
