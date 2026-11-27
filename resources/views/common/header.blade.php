<header class="site-header">
    <nav class="site-header__navigation">
        <a href="{{ route('product.index') }}">Home</a>
        <a href="{{ route('mypage.index') }}">マイページ</a>
        <span>ログインユーザー：{{ auth()->user()->name }}</span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="button button--danger">ログアウト</button>
        </form>
    </nav>

    <a href="{{ route('product.index') }}" class="site-header__title">
        MyShop
    </a>
</header>
