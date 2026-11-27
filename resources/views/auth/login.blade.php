@extends('layouts.app')

@section('title', 'ログイン')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<section class="auth-card">
    <h1>ログイン</h1>

    <form action="{{ route('login.store') }}" method="POST" class="form">
        @csrf

        <div class="form__group">
            <label for="email">メールアドレス</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="form__group">
            <label for="password">パスワード</label>
            <input id="password" name="password" type="password" required>
        </div>

        <label class="checkbox">
            <input type="checkbox" name="remember" value="1">
            ログイン状態を保持する
        </label>

        <button type="submit" class="button button--primary button--wide">
            ログイン
        </button>

        <a href="{{ route('register') }}" class="auth-card__link">
            新規登録はこちら
        </a>
    </form>
</section>
@endsection
