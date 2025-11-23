@extends('layouts.login_layout')

@section('title', 'メール認証誘導画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="form-wrapper">

    @if (session('message'))
    <div class="flash-message">
        {{ session('message') }}
    </div>
    @endif


    <h1 class="form-title">メール認証のお願い</h1>

    <p class="form-message">
        登録していただいたメールアドレスに認証メールをお送りしました。<br>
        メール認証を完了してください。
    </p>

    <div class="form-actions">
        <a href="http://localhost:8025" target="_blank" class="form-button">認証はこちらから</a>
    </div>

    <div class="form-resend">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="form-link-button">認証メールを再送する</button>
        </form>
    </div>

</div>
@endsection