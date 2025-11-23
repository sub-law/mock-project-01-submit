@extends('layouts.app')

@section('title', 'マイページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-wrapper">
    <div class="profile-box">
        <div class="profile-content">
            <img src="{{ asset('storage/profile_images/' . ($user->profile_image ?? 'no.image.png')) }}" alt="プロフィール画像" class="profile-icon">

            <p class="profile-name">{{ $user->name }}</p>
        </div>
        <a href="{{ route('mypage.profile') }}" class="edit-button">プロフィールを編集</a>
    </div>
</div>

<div class="product-tabs">
    <h2 class="section-title active" data-tab="selling">出品した商品</h2>
    <h2 class="section-title" data-tab="purchased">購入した商品</h2>
</div>

<div class="product-contents">
    <div class="product-row selling-list active">
        @foreach ($sellingProducts as $product)
        <a href="{{ route('product_show', ['item_id' => $product->id, 'from' => 'mypage']) }}" class="product-card">
            <div class="image-wrapper">
                <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
                @if ($product->status === 'sold')
                <div class="sold-label">Sold</div>
                @endif
            </div>
            <p class="product-name">{{ $product->name }}</p>
        </a>
        @endforeach
    </div>

    <div class="product-row purchased-list">
        @foreach ($purchasedProducts as $product)
        <a href="{{ route('product_show', ['item_id' => $product->id, 'from' => 'mypage']) }}" class="product-card">
            <div class="image-wrapper">
                <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
                @if ($product->status === 'sold')
                <div class="sold-label">Sold</div>
                @endif
            </div>
            <p class="product-name">{{ $product->name }}</p>
        </a>
        @endforeach
    </div>
</div>

<script>
    document.querySelectorAll('.section-title').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.section-title').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const selected = tab.dataset.tab;
            document.querySelectorAll('.product-row').forEach(list => list.classList.remove('active'));
            document.querySelector(`.${selected}-list`).classList.add('active');
        });
    });
</script>

@endsection