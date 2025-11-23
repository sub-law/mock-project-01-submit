@extends('layouts.app')

@section('title', '検索結果')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="search-header">
    <h2>「{{ $query }}」の検索結果</h2>

    @if ($products->isEmpty())
    <p class="empty-message">該当する商品は見つかりませんでした。</p>
    @else
    <p class="result-count">{{ $products->count() }}件見つかりました。</p>
    @endif
</div>

<div class="tab-wrapper">
    <div class="tab-menu">
        <a href="{{ route('search', ['query' => $query]) }}" class="{{ request('tab') !== 'mylist' ? 'tab-active' : 'tab' }}">おすすめ</a>
        <a href="{{ route('search', ['query' => $query, 'tab' => 'mylist']) }}" class="{{ request('tab') === 'mylist' ? 'tab-active' : 'tab' }}">マイリスト</a>
    </div>

    <div class="product-row">
        @if (request('tab') === 'mylist')
        @guest
        <p class="empty-message">マイリスト機能を利用するにはログインしてください。</p>
        @else
        @if ($products->isEmpty())
        {{-- 何も表示しない（仕様通り） --}}
        @else
        @foreach ($products as $product)
        <a href="{{ route('product_show', ['item_id' => $product->id]) }}" class="product-card">
            <div class="image-wrapper">
                <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
                @if ($product->status === 'sold')
                <div class="sold-label">Sold</div>
                @endif
            </div>
            <p class="product-name">{{ $product->name }}</p>
        </a>
        @endforeach
        @endif
        @endguest
        @else
        @foreach ($products as $product)
        <a href="{{ route('product_show', ['item_id' => $product->id]) }}" class="product-card">
            <div class="image-wrapper">
                <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="商品画像" class="product-image">
                @if ($product->status === 'sold')
                <div class="sold-label">Sold</div>
                @endif
            </div>
            <p class="product-name">{{ $product->name }}</p>
        </a>
        @endforeach
        @endif
    </div>
</div>
@endsection