@extends('layouts.app')

@section('title', '商品購入手続き')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<form action="{{ route('purchase.confirm', ['item_id' => $product->id]) }}" method="POST">
    @csrf

    <div class="checkout-grid">

        <div class="checkout-left">
            <section class="product-summary">
                <div class="product-info-box">
                    <img src="{{ asset('storage/products/' . ($product->image_path ?? 'default.jpg')) }}" alt="商品画像" class="product-image">

                    <div class="product-text">
                        <p class="product-name">{{ $product->name ?? '商品名未設定' }}</p>
                        <p class="product-price"><span class="yen">¥</span>{{ number_format($product->price ?? 0) }}</p>
                    </div>
                </div>
            </section>

            <section class="payment-method">
                <h2 class="payment-title">支払い方法</h2>
                <select name="payment_method" class="payment-select">
                    <option value="">選択してください</option>
                    <option value="convenience"
                        {{ old('payment_method', request('payment_method')) === 'convenience' ? 'selected' : '' }}>
                        コンビニ払い
                    </option>
                    <option value="credit"
                        {{ old('payment_method', request('payment_method')) === 'credit' ? 'selected' : '' }}>
                        カード支払い
                    </option>
                </select>

                @error('payment_method')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </section>

            <section class="delivery-info">
                <div class="delivery-header">
                    <h2 class="delivery-title">配送先</h2>
                    <a href="{{ route('address_edit', ['item_id' => $product->id]) }}" class="change-link">変更する</a>
                </div>

                <p class="delivery-address">
                    〒{{ $user->postal_code ?? '未登録' }}<br>
                    {{ $user->address ?? '住所未登録' }}<br>
                    {{ $user->building_name ?? '建物名未登録' }}
                </p>

                @error('address')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </section>
        </div>

        <section class="order-summary">
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">商品代金</span>
                    <span class="summary-value"><span class="yen">¥</span>{{ number_format($product->price ?? 0) }}</span>
                </div>

                <div class="summary-divider"></div>
                <div class="summary-row">
                    <span class="summary-label">支払い方法</span>
                    <span class="summary-value payment-summary">
                        @php
                        $method = old('payment_method', request('payment_method'));
                        @endphp
                        {{ $method === 'convenience' ? 'コンビニ払い' : ($method === 'credit' ? 'カード支払い' : '未選択') }}
                    </span>

                </div>
            </div>
            <button type="submit" class="purchase-button">購入する</button>
        </section>
    </div>
</form>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentSelect = document.querySelector('.payment-select');
        const paymentSummary = document.querySelector('.payment-summary');

        paymentSelect.addEventListener('change', function() {
            const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
            paymentSummary.textContent = selectedText || '未選択';
        });
    });
</script>