@extends('layouts.app')

@section('title', '新規ユーザー登録')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth-card auth-card--wide">
    <h1>新規ユーザー登録</h1>

    <form action="{{ route('register.store') }}" method="POST" class="form">
        @csrf

        <div class="form__group">
            <label for="name">Name（ユーザ名）</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
        </div>

        <div class="form__group">
            <label for="nameKanji">名前（漢字）</label>
            <input
                id="nameKanji"
                name="name_kanji"
                type="text"
                value="{{ old('name_kanji') }}"
                required
            >
        </div>

        <div class="form__group">
            <label for="nameKana">名前（カナ）</label>
            <input
                id="nameKana"
                name="name_kana"
                type="text"
                value="{{ old('name_kana') }}"
            >
        </div>

        <div class="form__group">
            <label for="email">メールアドレス</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
        </div>

        <div class="form__group">
            <label for="password">パスワード</label>
            <input id="password" name="password" type="password" required>
        </div>

        <div class="form__group">
            <label for="passwordConfirmation">パスワード（確認用）</label>
            <input
                id="passwordConfirmation"
                name="password_confirmation"
                type="password"
                required
            >
        </div>

        <div class="form__actions form__actions--center">
            <a href="{{ route('login') }}" class="button button--secondary">戻る</a>
            <button type="submit" class="button button--primary">登録</button>
        </div>
    </form>
</section>
@endsection
