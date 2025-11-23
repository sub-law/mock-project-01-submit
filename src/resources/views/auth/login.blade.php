@extends('layouts.login_layout')

@section('title', 'ログイン')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">ログイン</h1>

    @if(session('message'))
    <div class="flash-message">{{ session('message') }}</div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <label for="email" class="form-label">メールアドレス</label>
        <input type="text" id="email" name="email" class="form-input" value="{{ old('email') }}">

        @error('email')
        <div class="form-error">{{ $message }}</div>
        @enderror

        @error('auth')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="password" class="form-label">パスワード</label>
        <input type="password" id="password" name="password" class="form-input">
        @error('password')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <button type="submit" class="form-button">ログインする</button>
    </form>

    <a href="{{ route('register') }}" class="form-link">会員登録はこちら</a>
</div>

@endsection