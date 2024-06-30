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
            <p>ご予約ありがとうございます</p>
        </div>
    </div>
</div>
@endsection
