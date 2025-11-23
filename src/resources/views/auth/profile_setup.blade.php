@extends('layouts.app')

@section('title', 'プロフィール設定画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">プロフィール設定</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-image-area">
            <div class="form-image-wrapper">
                <div class="form-image-placeholder" id="imagePreview">
                    <img src="{{ asset('storage/profile_images/' . ($user->profile_image ?? 'no.image.png')) }}"
                        alt="プロフィール画像"
                        class="form-image-preview">
                </div>
                <label for="profile_image" class="form-image-button">画像を選択する</label>
                <input type="file" id="profile_image" name="profile_image" class="form-image-input" accept="image/*" hidden>
                @error('profile_image')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <label for="username" class="form-label">ユーザー名</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', Auth::user()->name) }}">
        @error('name')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="postal_code" class="form-label">郵便番号</label>
        <input type="text" id="postal_code" name="postal_code" class="form-input">
        @error('postal_code')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="address" class="form-label">住所</label>
        <input type="text" id="address" name="address" class="form-input">
        @error('address')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label for="building" class="form-label">建物名</label>
        <input type="text" id="building" name="building" class="form-input">

        <button type="submit" class="form-button">更新する</button>
    </form>
</div>

<script>
    document.getElementById('profile_image').addEventListener('change', function(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー画像" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 2px solid #FF5555;">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
</script>

@endsection