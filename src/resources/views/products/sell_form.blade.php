@extends('layouts.app')

@section('title', '商品出品画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sell_form.css') }}">
@endsection

@section('content')

<div class="form-wrapper">
    <h1 class="form-title">商品の出品</h1>

    <form method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-message">商品画像</div>
        <div class="form-image-box" id="imageBox">
            <label for="image_path" class="form-image-button-centered">画像を選択する</label>
            <input type="file" id="image_path" name="image_path" class="form-image-input" accept="image/*" hidden>
        </div>
        @error('image_path')
        <div class="form-error">{{ $message }}</div>
        @enderror

        {{-- カテゴリー選択 --}}
        <div class="form-category-wrapper">
            <div class="form-message-title">商品の詳細</div>
            <div class="form-message-category">カテゴリー</div>
            <div class="category-tags">
                @foreach ($categories as $category)
                <label class="category-tag">
                    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                        {{ collect(old('category_ids'))->contains($category->id) ? 'checked' : '' }}>
                    <span>{{ $category->name }}</span>
                </label>
                @endforeach
            </div>
            @error('category_ids')
            <div class="form-error">{{ $message }}</div>
            @enderror

            {{-- 商品の状態 --}}
            <label class="form-label" for="condition">商品の状態</label>
            <select id="condition" name="condition" class="form-select">
                <option value="">選択してください</option>
                @foreach(['良好','目立った傷や汚れなし','やや傷や汚れあり','状態が悪い'] as $cond)
                <option value="{{ $cond }}" {{ old('condition') === $cond ? 'selected' : '' }}>{{ $cond }}</option>
                @endforeach
            </select>
            @error('condition')
            <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- 商品名・ブランド名 --}}
        <label class="form-label" for="name">商品名</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}">
        @error('name')
        <div class="form-error">{{ $message }}</div>
        @enderror

        <label class="form-label" for="brand">ブランド名</label>
        <input type="text" id="brand" name="brand" class="form-input" value="{{ old('brand') }}">

        {{-- 商品説明 --}}
        <label class="form-label" for="description">商品の説明</label>
        <textarea id="description" name="description" class="form-input" rows="5" style="resize: vertical;">{{ old('description') }}</textarea>
        @error('description')
        <div class="form-error">{{ $message }}</div>
        @enderror

        {{-- 販売価格 --}}
        <label class="form-label" for="price">販売価格</label>
        <div class="form-input-with-symbol">
            <span class="yen-symbol">￥</span>
            <input type="number" id="price" name="price" class="form-input price-input"
                value="{{ old('price') }}" min="0">

        </div>
        @error('price')
        <div class="form-error">{{ $message }}</div>
        @enderror

        {{-- 出品ボタン --}}
        <button type="submit" class="form-button">出品する</button>
    </form>
</div>

<script>
    const input = document.getElementById('image_path');
    const imageBox = document.getElementById('imageBox');

    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const existing = imageBox.querySelector('.form-image-preview');
                if (existing) existing.remove();

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('form-image-preview');
                imageBox.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection