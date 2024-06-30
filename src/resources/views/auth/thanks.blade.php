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
            <p>会員登録ありがとうございます</p>
            <a href="{{ route('index') }}">ログインする</a>
        </div>
    </div>
</div>
@endsection
