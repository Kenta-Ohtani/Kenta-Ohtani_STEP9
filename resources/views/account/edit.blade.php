@extends('layouts.app')

@section('title', 'アカウント情報編集')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form-page.css') }}">
@endpush

@section('content')
<section class="form-page">
    <h1 class="page-title">アカウント情報編集</h1>

    <form action="{{ route('account.update') }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form__group">
            <label for="name">ユーザ名</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form__group">
            <label for="email">Eメール</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form__group">
            <label for="nameKanji">名前</label>
            <input
                id="nameKanji"
                name="name_kanji"
                type="text"
                value="{{ old('name_kanji', $user->name_kanji) }}"
                required
            >
        </div>

        <div class="form__group">
            <label for="nameKana">カナ</label>
            <input
                id="nameKana"
                name="name_kana"
                type="text"
                value="{{ old('name_kana', $user->name_kana) }}"
            >
        </div>

        <div class="form__actions form__actions--center">
            <a href="{{ route('mypage.index') }}" class="button button--secondary">
                戻る
            </a>
            <button type="submit" class="button button--primary">更新</button>
        </div>
    </form>
</section>
@endsection
