@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('main')
@component('components.nav_auth')
@endcomponent
<div class="thanks">
    <div class="thanks-parent">
        <div class="thanks__content">
            <p class="thanks__content--message">会員登録ありがとうございます</p>
            <p class="thanks__content--instruction">メールを送信しました<br>アドレスの認証をお願いします</p>
            <a href="mailto:" class="thanks__content--btn">メールソフトを開く</a>
        </div>
    </div>
</div>
@endsection
