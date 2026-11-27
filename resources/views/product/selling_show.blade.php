@extends('layouts.app')

@section('title', '出品商品詳細')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/delete-confirm.js') }}" defer></script>
@endpush

@section('content')
<section class="detail-card">
    <h1 class="page-title">出品商品詳細画面</h1>

    <dl class="detail-list">
        <div>
            <dt>商品名</dt>
            <dd>{{ $product->product_name }}</dd>
        </div>
        <div>
            <dt>説明</dt>
            <dd>{{ $product->description }}</dd>
        </div>
        <div>
            <dt>価格</dt>
            <dd>￥{{ number_format($product->price) }}</dd>
        </div>
    </dl>

    <img
        src="{{ asset('storage/' . $product->img_path) }}"
        alt="{{ $product->product_name }}"
        class="detail-image"
    >

    <div class="form__actions form__actions--center">
        <a href="{{ route('product.edit', $product) }}" class="button button--primary">
            編集
        </a>

        <form
            action="{{ route('product.destroy', $product) }}"
            method="POST"
            class="delete-form"
        >
            @csrf
            @method('DELETE')
            <button type="submit" class="button button--danger">削除する</button>
        </form>

        <a href="{{ route('mypage.index') }}" class="button button--secondary">
            戻る
        </a>
    </div>
</section>
@endsection
