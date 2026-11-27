<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyShop')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @stack('styles')
</head>
<body>
    @auth
        @include('common.header')
    @endauth

    <main class="main-content">
        @if(session('success'))
            <div class="flash-message flash-message--success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="flash-message flash-message--error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @auth
        @include('common.footer')
    @endauth

    @stack('scripts')
</body>
</html>
