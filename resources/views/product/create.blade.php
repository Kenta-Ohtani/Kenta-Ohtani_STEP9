@extends('layouts.app')

@section('title', '商品新規登録')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form-page.css') }}">
@endpush

@section('content')
<section class="form-page">
    <h1 class="page-title">商品新規登録</h1>

    <form
        action="{{ route('product.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="form"
    >
        @csrf
        @include('product.partials.form', ['product' => null])

        <div class="form__actions form__actions--center">
            <a href="{{ route('mypage.index') }}" class="button button--secondary">
                戻る
            </a>
            <button type="submit" class="button button--primary">登録</button>
        </div>
    </form>
</section>
@endsection
