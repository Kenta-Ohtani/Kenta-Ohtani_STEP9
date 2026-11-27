@extends('layouts.app')

@section('title', '商品一覧')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
<section class="page-card">
    <h1 class="page-title">商品一覧</h1>

    <form action="{{ route('product.index') }}" method="GET" class="search-form">
        <div class="search-form__field search-form__field--wide">
            <label for="productName">商品名</label>
            <input
                id="productName"
                name="product_name"
                type="text"
                value="{{ $product_name }}"
                placeholder="部分一致で検索"
            >
        </div>

        <div class="search-form__field">
            <label for="minPrice">最低価格</label>
            <input
                id="minPrice"
                name="min_price"
                type="number"
                min="0"
                value="{{ $min_price }}"
            >
        </div>

        <div class="search-form__field">
            <label for="maxPrice">最高価格</label>
            <input
                id="maxPrice"
                name="max_price"
                type="number"
                min="0"
                value="{{ $max_price }}"
            >
        </div>

        <button type="submit" class="button button--primary">検索</button>
    </form>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>商品番号</th>
                    <th>商品名</th>
                    <th>商品説明</th>
                    <th>画像</th>
                    <th>料金（￥）</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($product_list as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <img
                                src="{{ asset('storage/' . $product->img_path) }}"
                                alt="{{ $product->product_name }}"
                                class="product-thumbnail"
                            >
                        </td>
                        <td>{{ number_format($product->price) }}</td>
                        <td>
                            <a
                                href="{{ route('product.show', $product) }}"
                                class="button button--success"
                            >
                                詳細
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">該当する商品はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
