@extends('layouts.app')

@section('title', '商品詳細')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/like.js') }}" defer></script>
@endpush

@section('content')
<section class="detail-card">
    <h1 class="page-title">商品詳細</h1>

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

    <dl class="detail-list">
        <div>
            <dt>金額</dt>
            <dd>￥{{ number_format($product->price) }}</dd>
        </div>
        <div>
            <dt>会社</dt>
            <dd>{{ $product->company->company_name }}</dd>
        </div>
    </dl>

    <button
        id="likeButton"
        type="button"
        class="like-button {{ $is_liked ? 'like-button--active' : '' }}"
        data-url="{{ route('like.toggle', $product) }}"
        aria-pressed="{{ $is_liked ? 'true' : 'false' }}"
    >
        {{ $is_liked ? '♥' : '♡' }}
    </button>

    <div class="form__actions form__actions--center">
        <a href="{{ route('sale.create', $product) }}" class="button button--primary">
            カートに追加する
        </a>
        <a href="{{ route('product.index') }}" class="button button--secondary">
            戻る
        </a>
    </div>
</section>
@endsection
