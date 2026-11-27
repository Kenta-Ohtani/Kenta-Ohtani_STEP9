@extends('layouts.app')

@section('title', 'マイページ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endpush

@section('content')
<section class="mypage">
    <h1 class="page-title">マイページ</h1>

    <a href="{{ route('account.edit') }}" class="button button--primary">
        アカウント編集
    </a>

    <div class="mypage__user-grid">
        <p>ユーザ名：{{ $user->name }}</p>
        <p>名前：{{ $user->name_kanji }}</p>
        <p>Eメール：{{ $user->email }}</p>
        <p>カナ：{{ $user->name_kana ?: '未登録' }}</p>
    </div>

    <div class="mypage__section-header">
        <h2>出品商品</h2>
        <a href="{{ route('product.create') }}" class="button button--primary">
            新規登録
        </a>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>商品番号</th>
                    <th>商品名</th>
                    <th>商品説明</th>
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
                        <td>{{ number_format($product->price) }}</td>
                        <td>
                            <a
                                href="{{ route('product.selling.show', $product) }}"
                                class="button button--success"
                            >
                                詳細
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">出品商品はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mypage__section-header">
        <h2>購入した商品</h2>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>商品詳細</th>
                    <th>料金（￥）</th>
                    <th>個数</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sale_list as $sale)
                    <tr>
                        <td>{{ $sale->product->product_name }}</td>
                        <td>{{ $sale->product->description }}</td>
                        <td>{{ number_format($sale->product->price) }}</td>
                        <td>{{ $sale->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">購入した商品はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
