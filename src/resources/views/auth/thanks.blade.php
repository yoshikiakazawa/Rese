@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('main')
@component('components.nav')
@endcomponent
<div class="thanks">
    <div class="thanks-parent">
        <div class="thanks__content">
            <p class="thanks__content--message">会員登録ありがとうございます</p>
            <p class="thanks__content--instruction">メールを送信しました</p>
            <p class="thanks__content--instruction">アドレスの認証をお願いします</p>
            <p class="thanks__content--errorMessage">もしもメールが届かない場合にはアドレスの再確認お願いします</p>
        </div>
    </div>
</div>
@endsection
