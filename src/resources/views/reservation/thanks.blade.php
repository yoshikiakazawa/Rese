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
            <p class="thanks__content--message">ご予約ありがとうございます</p>
            <a class="thanks__content--btn" href="{{ route('index') }}">戻る</a>
        </div>
    </div>
</div>
@endsection
