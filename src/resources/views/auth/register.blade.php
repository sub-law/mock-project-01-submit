@extends('layouts.login_layout')

@section('title', '会員登録')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">会員登録</h1>

    <form method="POST" action="/register">
        @csrf

        <label for="name" class="form-label">ユーザー名</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}">
        @error('name')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="email" class="form-label">メールアドレス</label>
        <input type="text" id="email" name="email" class="form-input" value="{{ old('email') }}">
        @error('email')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="password" class="form-label">パスワード</label>
        <input type="password" id="password" name="password" class="form-input">
        @error('password')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="password_confirmation" class="form-label">確認用パスワード</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">

        <button type="submit" class="form-button">登録する</button>
    </form>

    <a href="{{ route('login') }}" class="form-link">ログインはこちら</a>
</div>
@endsection