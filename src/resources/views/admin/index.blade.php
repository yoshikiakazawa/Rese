@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
{{-- @if(Auth::check()) --}}
@component('components.nav_auth')
@endcomponent
{{-- @endif --}}
<div class="content">
    hello world!
</div>
@endsection
