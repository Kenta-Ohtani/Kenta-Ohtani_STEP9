@extends('layouts.app')

@section('title', '商品編集')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form-page.css') }}">
@endpush

@section('content')
<section class="form-page">
    <h1 class="page-title">商品編集</h1>

    <form
        action="{{ route('product.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
        class="form"
    >
        @csrf
        @method('PUT')
        @include('product.partials.form', ['product' => $product])

        <div class="form__actions form__actions--center">
            <a
                href="{{ route('product.selling.show', $product) }}"
                class="button button--secondary"
            >
                戻る
            </a>
            <button type="submit" class="button button--primary">更新</button>
        </div>
    </form>
</section>
@endsection
