@extends('layouts.app')

@section('title', '購入画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sale.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/sale.js') }}" defer></script>
@endpush

@section('content')
<section
    class="purchase-card"
    data-unit-price="{{ $product->price }}"
    data-stock="{{ $product->stock }}"
>
    <h1 class="page-title">購入画面</h1>

    <dl class="detail-list">
        <div>
            <dt>商品名</dt>
            <dd>{{ $product->product_name }}</dd>
        </div>
        <div>
            <dt>説明</dt>
            <dd>{{ $product->description }}</dd>
        </div>
    </dl>

    <img
        src="{{ asset('storage/' . $product->img_path) }}"
        alt="{{ $product->product_name }}"
        class="detail-image"
    >

    <form action="{{ route('sale.store', $product) }}" method="POST" class="form">
        @csrf

        <div class="form__group">
            <label for="quantity">数量</label>
            <input
                id="quantity"
                name="quantity"
                type="number"
                min="0"
                max="{{ $product->stock }}"
                value="{{ old('quantity', 0) }}"
                required
            >
        </div>

        <dl class="detail-list">
            <div>
                <dt>金額</dt>
                <dd id="totalPrice">￥0</dd>
            </div>
            <div>
                <dt>残り</dt>
                <dd>{{ $product->stock }}</dd>
            </div>
            <div>
                <dt>会社</dt>
                <dd>{{ $product->company->company_name }}</dd>
            </div>
        </dl>

        <div class="form__actions form__actions--center">
            <button
                id="purchaseButton"
                type="submit"
                class="button button--primary"
                disabled
            >
                購入する
            </button>
            <a href="{{ route('product.show', $product) }}" class="button button--secondary">
                戻る
            </a>
        </div>
    </form>
</section>
@endsection
