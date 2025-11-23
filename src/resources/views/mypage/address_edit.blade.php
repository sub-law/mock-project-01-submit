@extends('layouts.app')

@section('title', '送付先住所変更画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">住所の変更</h1>

    <form method="POST" action="{{ route('address_update', ['item_id' => $item_id]) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="postal_code" class="form-label">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" class="form-input"
                value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
            <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input type="text" id="address" name="address" class="form-input"
                value="{{ old('address', $user->address) }}">
            @error('address')
            <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" id="building" name="building_name" class="form-input"
                value="{{ old('building_name', $user->building_name) }}">

            @error('building_name')
            <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="form-button">更新する</button>
    </form>

</div>
@endsection