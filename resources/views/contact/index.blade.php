@extends('layouts.app')

@section('title', 'お問い合わせ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form-page.css') }}">
@endpush

@section('content')
<section class="form-page">
    <h1 class="page-title">お問い合わせフォーム</h1>

    <form action="{{ route('contact.send') }}" method="POST" class="form">
        @csrf

        <div class="form__group">
            <label for="contactName">名前</label>
            <input
                id="contactName"
                name="name"
                type="text"
                value="{{ old('name', auth()->user()->name_kanji) }}"
                required
            >
        </div>

        <div class="form__group">
            <label for="contactEmail">メールアドレス</label>
            <input
                id="contactEmail"
                name="email"
                type="email"
                value="{{ old('email', auth()->user()->email) }}"
                required
            >
        </div>

        <div class="form__group">
            <label for="contactContent">お問い合わせ内容</label>
            <textarea
                id="contactContent"
                name="contact_content"
                rows="10"
                required
            >{{ old('contact_content') }}</textarea>
        </div>

        <div class="form__actions form__actions--center">
            <button type="submit" class="button button--primary">送信</button>
            <a href="{{ route('product.index') }}" class="button button--secondary">
                戻る
            </a>
        </div>
    </form>
</section>
@endsection
